CREATE TABLE IF NOT EXISTS "migrations"(
  "id" integer primary key autoincrement not null,
  "migration" varchar not null,
  "batch" integer not null
);
CREATE TABLE IF NOT EXISTS "users"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "email" varchar not null,
  "email_verified_at" datetime,
  "password" varchar not null,
  "blocked" tinyint(1) not null default '0',
  "role" varchar not null default 'admin',
  "bridge_uuid_token" varchar,
  "token" varchar,
  "tiers_id" integer,
  "remember_token" varchar,
  "created_at" datetime,
  "updated_at" datetime,
  "two_factor_secret" text,
  "two_factor_recovery_codes" text,
  "two_factor_confirmed_at" datetime
);
CREATE UNIQUE INDEX "users_email_unique" on "users"("email");
CREATE TABLE IF NOT EXISTS "password_reset_tokens"(
  "email" varchar not null,
  "token" varchar not null,
  "created_at" datetime,
  primary key("email")
);
CREATE TABLE IF NOT EXISTS "sessions"(
  "id" varchar not null,
  "user_id" integer,
  "ip_address" varchar,
  "user_agent" text,
  "payload" text not null,
  "last_activity" integer not null,
  primary key("id")
);
CREATE INDEX "sessions_user_id_index" on "sessions"("user_id");
CREATE INDEX "sessions_last_activity_index" on "sessions"("last_activity");
CREATE TABLE IF NOT EXISTS "cache"(
  "key" varchar not null,
  "value" text not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE TABLE IF NOT EXISTS "cache_locks"(
  "key" varchar not null,
  "owner" varchar not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE TABLE IF NOT EXISTS "jobs"(
  "id" integer primary key autoincrement not null,
  "queue" varchar not null,
  "payload" text not null,
  "attempts" integer not null,
  "reserved_at" integer,
  "available_at" integer not null,
  "created_at" integer not null
);
CREATE INDEX "jobs_queue_index" on "jobs"("queue");
CREATE TABLE IF NOT EXISTS "job_batches"(
  "id" varchar not null,
  "name" varchar not null,
  "total_jobs" integer not null,
  "pending_jobs" integer not null,
  "failed_jobs" integer not null,
  "failed_job_ids" text not null,
  "options" text,
  "cancelled_at" integer,
  "created_at" integer not null,
  "finished_at" integer,
  primary key("id")
);
CREATE TABLE IF NOT EXISTS "failed_jobs"(
  "id" integer primary key autoincrement not null,
  "uuid" varchar not null,
  "connection" text not null,
  "queue" text not null,
  "payload" text not null,
  "exception" text not null,
  "failed_at" datetime not null default CURRENT_TIMESTAMP
);
CREATE UNIQUE INDEX "failed_jobs_uuid_unique" on "failed_jobs"("uuid");
CREATE TABLE IF NOT EXISTS "modules"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "slug" varchar not null,
  "description" text,
  "is_active" tinyint(1) not null default '0',
  "img_url" varchar,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "modules_slug_unique" on "modules"("slug");
CREATE TABLE IF NOT EXISTS "options"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "slug" varchar not null,
  "settings" text,
  "img_url" varchar,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "options_slug_unique" on "options"("slug");
CREATE TABLE IF NOT EXISTS "services"(
  "id" integer primary key autoincrement not null,
  "service_code" varchar not null,
  "status" varchar not null default 'ok',
  "max_user" integer not null default '0',
  "storage_limit" integer not null default '0',
  "created_at" datetime,
  "updated_at" datetime
);
CREATE TABLE IF NOT EXISTS "cities"(
  "id" integer primary key autoincrement not null,
  "city" varchar,
  "postal_code" varchar,
  "latitude" varchar,
  "longitude" varchar
);
CREATE TABLE IF NOT EXISTS "countries"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null
);
CREATE TABLE IF NOT EXISTS "plan_comptables"(
  "id" integer primary key autoincrement not null,
  "code" varchar,
  "account" varchar,
  "type" varchar,
  "lettrage" tinyint(1) not null,
  "principal" varchar,
  "initial" float
);
CREATE TABLE IF NOT EXISTS "companies"(
  "id" integer primary key autoincrement not null,
  "name" varchar,
  "address" varchar,
  "code_postal" varchar,
  "ville" varchar,
  "pays" varchar,
  "num_tva" varchar,
  "siret" varchar,
  "ape" varchar,
  "capital" varchar,
  "phone" varchar,
  "fax" varchar,
  "email" varchar,
  "web" varchar,
  "rcs" varchar,
  "logo" varchar,
  "logo_wide" varchar,
  "bridge_client_id" varchar
);
CREATE TABLE IF NOT EXISTS "banks"(
  "id" integer primary key autoincrement not null,
  "bridge_id" integer not null,
  "name" varchar not null,
  "logo_bank" varchar not null,
  "status_aggregation" varchar,
  "status_payment" varchar
);
CREATE TABLE IF NOT EXISTS "condition_reglements"(
  "id" integer primary key autoincrement not null,
  "code" varchar not null,
  "name" varchar not null,
  "name_document" varchar not null,
  "nb_jours" integer not null,
  "fdm" tinyint(1) not null
);
CREATE TABLE IF NOT EXISTS "mode_reglements"(
  "id" integer primary key autoincrement not null,
  "code" varchar not null,
  "name" varchar not null,
  "type_paiement" text not null,
  "bridgeable" tinyint(1) not null default '0'
);
CREATE TABLE IF NOT EXISTS "personal_access_tokens"(
  "id" integer primary key autoincrement not null,
  "tokenable_type" varchar not null,
  "tokenable_id" integer not null,
  "name" text not null,
  "token" varchar not null,
  "abilities" text,
  "last_used_at" datetime,
  "expires_at" datetime,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE INDEX "personal_access_tokens_tokenable_type_tokenable_id_index" on "personal_access_tokens"(
  "tokenable_type",
  "tokenable_id"
);
CREATE UNIQUE INDEX "personal_access_tokens_token_unique" on "personal_access_tokens"(
  "token"
);
CREATE INDEX "personal_access_tokens_expires_at_index" on "personal_access_tokens"(
  "expires_at"
);
CREATE TABLE IF NOT EXISTS "settings"(
  "id" integer primary key autoincrement not null,
  "key" varchar not null,
  "value" text
);
CREATE UNIQUE INDEX "settings_key_unique" on "settings"("key");
CREATE TABLE IF NOT EXISTS "notifications"(
  "id" varchar not null,
  "type" varchar not null,
  "notifiable_type" varchar not null,
  "notifiable_id" integer not null,
  "data" text not null,
  "read_at" datetime,
  "created_at" datetime,
  "updated_at" datetime,
  primary key("id")
);
CREATE INDEX "notifications_notifiable_type_notifiable_id_index" on "notifications"(
  "notifiable_type",
  "notifiable_id"
);
CREATE TABLE IF NOT EXISTS "tiers"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "nature" varchar not null,
  "type" varchar not null,
  "code_tiers" varchar not null,
  "siren" varchar,
  "tva" tinyint(1) not null,
  "num_tva" varchar
);
CREATE TABLE IF NOT EXISTS "tiers_addresses"(
  "id" integer primary key autoincrement not null,
  "address" varchar,
  "code_postal" varchar,
  "ville" varchar,
  "pays" varchar,
  "tiers_id" integer not null,
  foreign key("tiers_id") references "tiers"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "tiers_contacts"(
  "id" integer primary key autoincrement not null,
  "nom" varchar,
  "prenom" varchar,
  "civilite" varchar,
  "poste" varchar,
  "tel" varchar,
  "portable" varchar,
  "email" varchar,
  "tiers_id" integer not null,
  foreign key("tiers_id") references "tiers"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "tiers_supplies"(
  "id" integer primary key autoincrement not null,
  "tva" tinyint(1) not null,
  "num_tva" varchar,
  "rem_relative" varchar,
  "rem_fixe" varchar,
  "code_comptable_general" integer not null,
  "code_comptable_fournisseur" integer not null,
  "tiers_id" integer not null,
  "condition_reglement_id" integer not null,
  "mode_reglement_id" integer not null,
  foreign key("code_comptable_general") references "plan_comptables"("id"),
  foreign key("code_comptable_fournisseur") references "plan_comptables"("id"),
  foreign key("tiers_id") references "tiers"("id") on delete cascade on update cascade,
  foreign key("condition_reglement_id") references "condition_reglements"("id"),
  foreign key("mode_reglement_id") references "mode_reglements"("id")
);
CREATE TABLE IF NOT EXISTS "tiers_customers"(
  "id" integer primary key autoincrement not null,
  "tva" tinyint(1) not null,
  "num_tva" varchar,
  "rem_relative" varchar not null,
  "rem_fixe" varchar not null,
  "code_comptable_general" integer not null,
  "code_comptable_client" integer not null,
  "tiers_id" integer not null,
  "condition_reglement_id" integer not null,
  "mode_reglement_id" integer not null,
  foreign key("code_comptable_general") references "plan_comptables"("id") on delete cascade on update cascade,
  foreign key("code_comptable_client") references "plan_comptables"("id") on delete cascade on update cascade,
  foreign key("tiers_id") references "tiers"("id") on delete cascade on update cascade,
  foreign key("condition_reglement_id") references "condition_reglements"("id"),
  foreign key("mode_reglement_id") references "mode_reglements"("id")
);
CREATE TABLE IF NOT EXISTS "tiers_logs"(
  "id" integer primary key autoincrement not null,
  "title" varchar not null,
  "event_day" tinyint(1) not null default '0',
  "start_at" datetime,
  "end_at" datetime,
  "status" varchar,
  "description" text,
  "lieu" varchar,
  "user_id" integer not null,
  "tiers_id" integer,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id")
);
CREATE TABLE IF NOT EXISTS "tiers_banks"(
  "id" integer primary key autoincrement not null,
  "iban" varchar not null,
  "bic" varchar not null,
  "external_id" varchar,
  "tiers_id" integer not null,
  "bank_id" integer not null,
  "default" tinyint(1) not null,
  foreign key("tiers_id") references "tiers"("id") on delete cascade on update cascade,
  foreign key("bank_id") references "banks"("id")
);
CREATE TABLE IF NOT EXISTS "chantiers"(
  "id" integer primary key autoincrement not null,
  "libelle" varchar not null,
  "description" text,
  "date_debut" date not null,
  "date_fin_prevu" date not null,
  "date_fin_reel" date,
  "status" varchar not null default 'planifie',
  "budget_estime" numeric not null,
  "budget_reel" numeric not null,
  "tiers_id" integer not null,
  "user_id" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("tiers_id") references "tiers"("id"),
  foreign key("user_id") references "users"("id")
);
CREATE TABLE IF NOT EXISTS "chantiers_tasks"(
  "id" integer primary key autoincrement not null,
  "libelle" varchar not null,
  "description" text,
  "date_debut_prevu" date not null,
  "date_fin_prevue" date not null,
  "date_debut_reel" date,
  "date_fin_reel" date,
  "status" varchar not null,
  "priority" varchar not null,
  "assigned_id" integer,
  "chantiers_id" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("chantiers_id") references "chantiers"("id")
);
CREATE TABLE IF NOT EXISTS "chantiers_depenses"(
  "id" integer primary key autoincrement not null,
  "description" varchar not null,
  "montant" numeric not null,
  "date_depense" date not null,
  "type_depense" varchar not null,
  "invoice_ref" varchar,
  "tiers_id" integer not null,
  "chantiers_id" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("tiers_id") references "tiers"("id"),
  foreign key("chantiers_id") references "chantiers"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "chantiers_interventions"(
  "id" integer primary key autoincrement not null,
  "date_intervention" date not null default '2025-11-10 23:26:49',
  "description" text not null,
  "temps" numeric,
  "facturable" tinyint(1) not null default '1',
  "chantiers_id" integer not null,
  "intervenant_id" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("chantiers_id") references "chantiers"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "chantiers_addresses"(
  "id" integer primary key autoincrement not null,
  "address" varchar not null,
  "code_postal" varchar not null,
  "ville" varchar not null,
  "pays" varchar not null,
  "latitude" varchar,
  "longitude" varchar,
  "chantiers_id" integer not null,
  foreign key("chantiers_id") references "chantiers"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "chantiers_user"(
  "chantiers_id" integer not null,
  "user_id" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("chantiers_id") references "chantiers"("id") on delete cascade,
  foreign key("user_id") references "users"("id") on delete cascade,
  primary key("chantiers_id", "user_id")
);
CREATE TABLE IF NOT EXISTS "chantiers_logs"(
  "id" integer primary key autoincrement not null,
  "libelle" varchar not null,
  "user_id" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id")
);

INSERT INTO migrations VALUES(1,'0001_01_01_000000_create_users_table',1);
INSERT INTO migrations VALUES(2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO migrations VALUES(3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO migrations VALUES(4,'2025_09_22_145432_add_two_factor_columns_to_users_table',1);
INSERT INTO migrations VALUES(5,'2025_10_11_223023_create_modules_table',1);
INSERT INTO migrations VALUES(6,'2025_10_11_223430_create_options_table',1);
INSERT INTO migrations VALUES(7,'2025_10_11_223437_create_services_table',1);
INSERT INTO migrations VALUES(8,'2025_10_16_194531_create_cities_table',1);
INSERT INTO migrations VALUES(9,'2025_10_16_200142_create_countries_table',1);
INSERT INTO migrations VALUES(10,'2025_10_16_200459_create_plan_comptables_table',1);
INSERT INTO migrations VALUES(11,'2025_10_16_201205_create_companies_table',1);
INSERT INTO migrations VALUES(12,'2025_10_16_202524_create_banks_table',1);
INSERT INTO migrations VALUES(13,'2025_10_17_130557_create_condition_reglements_table',1);
INSERT INTO migrations VALUES(14,'2025_10_17_130847_create_mode_reglements_table',1);
INSERT INTO migrations VALUES(15,'2025_11_01_195109_create_personal_access_tokens_table',1);
INSERT INTO migrations VALUES(16,'2025_11_01_195915_create_settings_table',1);
INSERT INTO migrations VALUES(17,'2025_11_01_195916_add_settings_team_field',1);
INSERT INTO migrations VALUES(18,'2025_11_01_200421_create_notifications_table',1);
INSERT INTO migrations VALUES(19,'2025_11_09_192206_create_tiers_table',1);
INSERT INTO migrations VALUES(20,'2025_11_09_194030_create_tiers_addresses_table',1);
INSERT INTO migrations VALUES(21,'2025_11_09_195856_create_tiers_contacts_table',1);
INSERT INTO migrations VALUES(22,'2025_11_09_200240_create_tiers_supplies_table',1);
INSERT INTO migrations VALUES(23,'2025_11_09_200620_create_tiers_customers_table',1);
INSERT INTO migrations VALUES(24,'2025_11_09_200904_create_tiers_logs_table',1);
INSERT INTO migrations VALUES(25,'2025_11_09_201111_create_tiers_banks_table',1);
INSERT INTO migrations VALUES(26,'2025_11_10_225856_create_chantiers_table',1);
INSERT INTO migrations VALUES(27,'2025_11_10_230440_create_chantiers_tasks_table',1);
INSERT INTO migrations VALUES(28,'2025_11_10_231021_create_chantiers_depenses_table',1);
INSERT INTO migrations VALUES(29,'2025_11_10_231404_create_chantiers_interventions_table',1);
INSERT INTO migrations VALUES(30,'2025_11_10_231829_create_chantiers_addresses_table',1);
INSERT INTO migrations VALUES(31,'2025_11_10_232057_create_chantiers_user_table',1);
INSERT INTO migrations VALUES(32,'2025_11_10_232256_create_chantiers_logs_table',1);
