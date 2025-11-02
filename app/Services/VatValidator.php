<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class VatValidator
{
    /**
     * URL du service VIES (SOAP).
     */
    protected const VIES_WSDL_URL = 'https://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl';

    /**
     * Vérifie la validité d'un numéro de TVA intracommunautaire via l'API VIES.
     *
     * @param string $vatNumber Le numéro de TVA (avec le code pays, ex: FRXX123456789).
     * @return bool Vrai si le numéro est valide et actif.
     */
    public function isValid(string $vatNumber): bool
    {
        // 1. Nettoyage et vérification de la syntaxe
        $vatNumber = $this->cleanVatNumber($vatNumber);

        if (!$this->isSyntacticallyValid($vatNumber)) {
            Log::info("TVA $vatNumber rejetée: format incorrect.");
            return false;
        }

        // 2. Extraction du code pays et du numéro
        $countryCode = substr($vatNumber, 0, 2);
        $number = substr($vatNumber, 2);

        // 3. Appel à l'API VIES
        return $this->checkVies($countryCode, $number);
    }

    /**
     * Nettoie le numéro de TVA (enlève les espaces, tirets, etc.).
     */
    protected function cleanVatNumber(string $vatNumber): string
    {
        return strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', $vatNumber));
    }

    /**
     * Vérifie la validité syntaxique simple (format initial).
     *
     * NOTE: Cette REGEX est un exemple pour les pays les plus courants. 
     * Il est fortement recommandé d'utiliser une REGEX plus complète (voir ci-dessous).
     * Exemple ici: 2 lettres (code pays) suivi d'au moins 2 caractères (chiffres/lettres)
     */
    protected function isSyntacticallyValid(string $vatNumber): bool
    {
        $vatNumber = $this->cleanVatNumber($vatNumber);

        $regex = '/^((AT)U\d{8}|(BE)(0\d{9})|(BG)\d{9,10}|(CY)\d{8}[A-Z]|(CZ)\d{8,10}|(DE)\d{9}|(DK)\d{8}|(EE)\d{9}|(EL)\d{9}|(ES)([A-Z]\d{8}|\d{8}[A-Z]|[A-Z]\d{7}[A-Z])|(FI)\d{8}|(FR)[A-Z0-9]{2}\d{9}|(HR)\d{11}|(HU)\d{8}|(IE)\d{7}[A-Z]{1,2}|(IT)\d{11}|(LT)(\d{9}|\d{12})|(LU)\d{8}|(LV)\d{11}|(MT)\d{8}|(NL)\d{9}B\d{2}|(PL)\d{10}|(PT)\d{9}|(RO)\d{2,10}|(SE)\d{12}|(SI)\d{8}|(SK)\d{10})$/';

        return preg_match($regex, $vatNumber);
    }

    /**
     * Interroge le service VIES pour la validation réelle.
     */
    protected function checkVies(string $countryCode, string $vatNumber): bool
    {
        try {
            $client = new Client();
            $xmlBody = $this->buildSoapRequest($countryCode, $vatNumber);

            $response = $client->post(self::VIES_WSDL_URL, [
                'headers' => [
                    'Content-Type' => 'text/xml;charset=UTF-8',
                    'SOAPAction' => 'urn:ec.europa.eu:taxation_customs:vies:services:checkVat:checkVat',
                ],
                'body' => $xmlBody,
                // Le WSDL VIES utilise SOAP. On peut utiliser l'URL du WSDL 
                // comme endpoint, Guzzle se chargera de l'envoi du corps SOAP.
            ]);

            $body = (string) $response->getBody();
            return $this->parseSoapResponse($body);

        } catch (RequestException $e) {
            // Log l'erreur de requête (ex: Timeout, Problème réseau)
            Log::error('Erreur de requête VIES pour ' . $countryCode . $vatNumber . ': ' . $e->getMessage());
            // En cas d'erreur de connexion, on peut choisir de retourner `false` ou 
            // de lancer une exception selon le comportement souhaité. Ici, on est prudent.
            return false;
        } catch (\Exception $e) {
            // Autres erreurs (Parsing, etc.)
            Log::error('Erreur VIES inattendue: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Construit le corps de la requête SOAP.
     */
    protected function buildSoapRequest(string $countryCode, string $vatNumber): string
    {
        // Supprime les caractères non nécessaires pour l'appel VIES après le nettoyage
        $vatNumber = preg_replace('/[^0-9A-Z]/', '', $vatNumber);

        return <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:vies="urn:ec.europa.eu:taxation_customs:vies:services:checkVat:checkVat">
   <soapenv:Header/>
   <soapenv:Body>
      <vies:checkVat>
         <vies:countryCode>{$countryCode}</vies:countryCode>
         <vies:vatNumber>{$vatNumber}</vies:vatNumber>
      </vies:checkVat>
   </soapenv:Body>
</soapenv:Envelope>
XML;
    }

    /**
     * Analyse la réponse SOAP pour déterminer la validité.
     */
    protected function parseSoapResponse(string $body): bool
    {
        // Suppression des namespaces pour simplifier l'accès avec SimpleXMLElement
        $body = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $body);
        
        try {
            $xml = simplexml_load_string($body);
            // On cherche l'élément 'valid' dans la réponse VIES
            $validElement = $xml->Body->checkVatResponse->valid ?? null;

            return $validElement === 'true';
        } catch (\Exception $e) {
            Log::error('Erreur de parsing de la réponse SOAP VIES: ' . $e->getMessage());
            return false;
        }
    }
}