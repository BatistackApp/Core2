<div class="kt-container-fixed">
    <form wire:submit="updateUser">
        <div class="kt-card">
            <div class="kt-card-header">
                <div class="kt-card-heading">
                    <h2 class="kt-card-title">Mes Informations</h2>
                </div>
                <div class="kt-card-toolbar">
                    <button type="submit" class="kt-btn kt-btn-primary">Sauvegarder</button>
                </div>
            </div>
            <div class="kt-card-content py-5">
                {{ $this->form }}
            </div>
        </div>
    </form>
    <div class="kt-card mt-5 text-white">
        <div class="kt-card-header bg-orange-400">
            <div class="kt-card-heading">
                <h2 class="kt-card-title">Suppression de compte</h2>
            </div>
            <div class="kt-card-toolbar">
                {{ $this->deleteUserAction }}
            </div>
        </div>
        <div class="kt-card-content bg-orange-300 py-5">
            <p class="text-orange-700 font-black text-lg">Attention, cette action est définitive et irréversible.</p>
            <p>La suppression de votre compte entrainera les conséquences suivantes, immédiates et permanentes :</p>
            <ul>
                <li>Perte de toutes vos données : Votre profil, vos paramètres, et tous les contenus que vous avez créés (publications, commentaires, favoris, etc.) seront effacés.</li>
                <li>Accès interrompu : Vous ne pourrez plus vous connecter à l'application avec cet identifiant.</li>
            </ul>

            <p>Nous vous recommandons de télécharger vos données avant de continuer si vous souhaitez conserver une copie de vos informations.</p>
        </div>
    </div>
    <x-filament-actions::modals />
</div>
