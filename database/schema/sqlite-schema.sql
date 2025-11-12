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
CREATE TABLE IF NOT EXISTS "schedules"(
  "id" integer primary key autoincrement not null,
  "schedulable_type" varchar not null,
  "schedulable_id" integer not null,
  "name" varchar,
  "description" text,
  "start_date" date not null,
  "end_date" date,
  "is_recurring" tinyint(1) not null default '0',
  "frequency" varchar,
  "frequency_config" text,
  "metadata" text,
  "is_active" tinyint(1) not null default '1',
  "created_at" datetime,
  "updated_at" datetime,
  "schedule_type" varchar check("schedule_type" in('availability', 'appointment', 'blocked', 'custom')) not null default 'custom'
);
CREATE INDEX "schedules_schedulable_type_schedulable_id_index" on "schedules"(
  "schedulable_type",
  "schedulable_id"
);
CREATE INDEX "schedules_schedulable_index" on "schedules"(
  "schedulable_type",
  "schedulable_id"
);
CREATE INDEX "schedules_date_range_index" on "schedules"(
  "start_date",
  "end_date"
);
CREATE INDEX "schedules_is_active_index" on "schedules"("is_active");
CREATE INDEX "schedules_is_recurring_index" on "schedules"("is_recurring");
CREATE INDEX "schedules_frequency_index" on "schedules"("frequency");
CREATE TABLE IF NOT EXISTS "schedule_periods"(
  "id" integer primary key autoincrement not null,
  "schedule_id" integer not null,
  "date" date not null,
  "start_time" time not null,
  "end_time" time not null,
  "is_available" tinyint(1) not null default '1',
  "metadata" text,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("schedule_id") references "schedules"("id") on delete cascade
);
CREATE INDEX "schedule_periods_schedule_date_index" on "schedule_periods"(
  "schedule_id",
  "date"
);
CREATE INDEX "schedule_periods_time_range_index" on "schedule_periods"(
  "date",
  "start_time",
  "end_time"
);
CREATE INDEX "schedule_periods_is_available_index" on "schedule_periods"(
  "is_available"
);
CREATE INDEX "schedules_type_index" on "schedules"("schedule_type");
CREATE INDEX "schedules_schedulable_type_index" on "schedules"(
  "schedulable_type",
  "schedulable_id",
  "schedule_type"
);
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
CREATE TABLE IF NOT EXISTS "warehouses"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "address" varchar not null,
  "code_postal" varchar not null,
  "ville" varchar not null,
  "pays" varchar not null,
  "is_default" tinyint(1) not null default '1'
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
CREATE TABLE IF NOT EXISTS "units"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "symbol" varchar not null,
  "type" varchar
);
CREATE TABLE IF NOT EXISTS "article_categories"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "description" text,
  "parent_id" integer,
  foreign key("parent_id") references "article_categories"("id") on delete set null
);
CREATE TABLE IF NOT EXISTS "articles"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "description" text,
  "reference" varchar,
  "barcode" varchar,
  "type_article" varchar not null default 'material',
  "is_stock_managed" tinyint(1) not null default '0',
  "stock_alert_threshold" numeric,
  "price_achat_ht" numeric,
  "prix_vente_ht" numeric,
  "vat_rate" numeric not null default '20',
  "is_active" tinyint(1) not null default '1',
  "unit_id" integer,
  "article_category_id" integer,
  "created_at" datetime,
  "updated_at" datetime,
  "deleted_at" datetime,
  foreign key("unit_id") references "units"("id") on delete set null,
  foreign key("article_category_id") references "article_categories"("id") on delete set null
);
CREATE TABLE IF NOT EXISTS "article_prices"(
  "id" integer primary key autoincrement not null,
  "articles_id" integer not null,
  "tiers_id" integer,
  "price_level_name" varchar,
  "min_quantity" numeric not null,
  "price_ht" numeric not null,
  foreign key("articles_id") references "articles"("id") on delete cascade,
  foreign key("tiers_id") references "tiers"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "article_stocks"(
  "id" integer primary key autoincrement not null,
  "articles_id" integer not null,
  "warehouse_id" integer not null,
  "quantity" numeric not null default '0',
  "quantity_reserved" numeric not null default '0',
  foreign key("articles_id") references "articles"("id") on delete cascade,
  foreign key("warehouse_id") references "warehouses"("id") on delete cascade
);
CREATE UNIQUE INDEX "article_stocks_articles_id_warehouse_id_unique" on "article_stocks"(
  "articles_id",
  "warehouse_id"
);
CREATE TABLE IF NOT EXISTS "article_ouvrages"(
  "id" integer primary key autoincrement not null,
  "parent_article_id" integer not null,
  "child_article_id" integer not null,
  "quantity" numeric not null,
  foreign key("parent_article_id") references "articles"("id") on delete cascade,
  foreign key("child_article_id") references "articles"("id") on delete cascade
);
CREATE UNIQUE INDEX "article_ouvrages_parent_article_id_child_article_id_unique" on "article_ouvrages"(
  "parent_article_id",
  "child_article_id"
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
  "date_intervention" date not null default '2025-11-12 18:01:19',
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
CREATE TABLE IF NOT EXISTS "chantiers_postes"(
  "id" integer primary key autoincrement not null,
  "description" varchar not null,
  "quantity" numeric not null,
  "unit" varchar,
  "unit_price_ht" numeric not null,
  "total_budget_amount" numeric not null,
  "current_progress_percentage" numeric not null,
  "chantiers_id" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  "deleted_at" datetime
);
CREATE TABLE IF NOT EXISTS "devis"(
  "id" integer primary key autoincrement not null,
  "num_devis" varchar not null,
  "date_devis" date not null,
  "date_validate" date,
  "status" varchar not null default 'draft',
  "amount_ht" numeric not null,
  "amount_ttc" numeric not null,
  "notes" text,
  "chantiers_id" integer,
  "tiers_id" integer not null,
  "responsable_id" integer not null,
  foreign key("tiers_id") references "tiers"("id") on update cascade,
  foreign key("responsable_id") references "users"("id") on update cascade
);
CREATE TABLE IF NOT EXISTS "devis_lignes"(
  "id" integer primary key autoincrement not null,
  "type" varchar not null,
  "libelle" varchar not null,
  "description" text,
  "qte" numeric not null,
  "puht" numeric not null,
  "amount_ht" numeric not null,
  "tva_rate" numeric not null,
  "devis_id" integer not null,
  foreign key("devis_id") references "devis"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "commandes"(
  "id" integer primary key autoincrement not null,
  "num_commande" varchar not null,
  "date_commande" date not null,
  "status" varchar not null default 'pending',
  "amount_ht" numeric not null,
  "amount_ttc" numeric not null,
  "devis_id" integer,
  "chantiers_id" integer,
  "tiers_id" integer not null,
  "responsable_id" integer not null
);
CREATE TABLE IF NOT EXISTS "commande_lignes"(
  "id" integer primary key autoincrement not null,
  "type" varchar not null,
  "libelle" varchar not null,
  "description" text,
  "qte" numeric not null,
  "puht" numeric not null,
  "amount_ht" numeric not null,
  "tva_rate" numeric not null,
  "commande_id" integer not null,
  foreign key("commande_id") references "commandes"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "settings"(
  "id" integer primary key autoincrement not null,
  "group" varchar not null,
  "name" varchar not null,
  "locked" tinyint(1) not null default '0',
  "payload" text not null,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "settings_group_name_unique" on "settings"(
  "group",
  "name"
);
CREATE TABLE IF NOT EXISTS "factures"(
  "id" integer primary key autoincrement not null,
  "num_facture" varchar not null,
  "status" varchar not null default 'draft',
  "type_facture" varchar not null default 'standard',
  "date_facture" date not null,
  "date_echue" date not null,
  "situation_started_at" date,
  "situtation_ended_at" date,
  "progress_percentage" numeric,
  "total_work_to_date" numeric,
  "previous_situations_total" numeric,
  "guarantee_retention_percentage" numeric,
  "guarantee_retention_amount" numeric,
  "guarantee_released" tinyint(1) not null default '0',
  "amount_ht" numeric not null,
  "amount_tva" numeric not null,
  "amount_ttc" numeric not null,
  "notes" text,
  "pdf_path" varchar,
  "user_id" integer,
  "tiers_id" integer not null,
  "chantiers_id" integer,
  "commande_id" integer,
  "parent_facture_id" integer,
  "created_at" datetime,
  "updated_at" datetime,
  "deleted_at" datetime,
  foreign key("user_id") references "users"("id") on delete set null,
  foreign key("tiers_id") references "tiers"("id") on delete restrict,
  foreign key("chantiers_id") references "chantiers"("id") on delete restrict,
  foreign key("commande_id") references "commandes"("id") on delete set null,
  foreign key("parent_facture_id") references "factures"("id") on delete set null
);
CREATE UNIQUE INDEX "factures_num_facture_unique" on "factures"("num_facture");
CREATE TABLE IF NOT EXISTS "facture_lignes"(
  "id" integer primary key autoincrement not null,
  "description" varchar not null,
  "vat_rate" numeric not null default '20',
  "quantity" numeric,
  "unit" varchar,
  "unit_price_ht" numeric,
  "total_budget_amount" numeric,
  "previous_progress_percentage" numeric,
  "current_progress_percentage" numeric,
  "amount_ht" numeric not null,
  "amount_tva" numeric not null,
  "amount_tc" numeric not null,
  "facture_id" integer not null,
  "chantiers_poste_id" integer,
  "articles_id" integer,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("facture_id") references "factures"("id") on delete cascade,
  foreign key("chantiers_poste_id") references "chantiers_postes"("id") on delete set null,
  foreign key("articles_id") references "articles"("id") on delete set null
);
CREATE TABLE IF NOT EXISTS "payments"(
  "id" integer primary key autoincrement not null,
  "tiers_id" integer not null,
  "amount" numeric not null,
  "paid_at" date not null,
  "mode_reglement_id" integer not null,
  "reference" varchar,
  "status" varchar not null default 'unallocated',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("tiers_id") references "tiers"("id") on delete restrict
);
CREATE TABLE IF NOT EXISTS "facture_payment"(
  "id" integer primary key autoincrement not null,
  "facture_id" integer not null,
  "payment_id" integer not null,
  "amount_applied" numeric not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("facture_id") references "factures"("id") on delete cascade,
  foreign key("payment_id") references "payments"("id") on delete cascade
);
CREATE UNIQUE INDEX "facture_payment_facture_id_payment_id_unique" on "facture_payment"(
  "facture_id",
  "payment_id"
);
CREATE TABLE IF NOT EXISTS "facture_recurrings"(
  "id" integer primary key autoincrement not null,
  "tiers_id" integer not null,
  "status" varchar not null default 'active',
  "frequency" varchar not null default 'monthly',
  "start_at" date not null,
  "end_at" date,
  "last_generated_at" date,
  "next_generation_at" date,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("tiers_id") references "tiers"("id") on delete restrict
);
CREATE TABLE IF NOT EXISTS "facture_reminders"(
  "id" integer primary key autoincrement not null,
  "facture_id" integer not null,
  "level" integer not null,
  "status" varchar not null,
  "send_at" datetime not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("facture_id") references "factures"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "bank_connections"(
  "id" integer primary key autoincrement not null,
  "user_id" integer,
  "bridge_item_id" varchar not null,
  "status" varchar not null default 'active',
  "last_synced_at" datetime,
  "credentials" text,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete cascade
);
CREATE UNIQUE INDEX "bank_connections_bridge_item_id_unique" on "bank_connections"(
  "bridge_item_id"
);
CREATE TABLE IF NOT EXISTS "bank_accounts"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "type" varchar not null default 'compte',
  "bank_name" varchar,
  "iban" varchar,
  "bic" varchar,
  "currency" varchar not null default 'EUR',
  "current_balance" numeric not null default '0',
  "is_default" tinyint(1) not null default '0',
  "bank_connection_id" integer,
  "provider_account_id" varchar,
  "sync_enabled" tinyint(1) not null default '0',
  "account_last_synced_at" datetime,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("bank_connection_id") references "bank_connections"("id") on delete set null
);
CREATE TABLE IF NOT EXISTS "bank_transactions"(
  "id" integer primary key autoincrement not null,
  "bank_account_id" integer not null,
  "transaction_date" date not null,
  "value_date" date,
  "label" varchar not null,
  "amount" numeric not null,
  "bank_reference" varchar,
  "provider_transaction_id" varchar,
  "is_from_sync" tinyint(1) not null default '0',
  "status" varchar not null default 'unreconciled',
  "reconcilable_type" varchar not null,
  "reconcilable_id" integer not null,
  "reconciled_at" datetime,
  "reconciled_by_user_id" integer,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("bank_account_id") references "bank_accounts"("id") on delete cascade,
  foreign key("reconciled_by_user_id") references "users"("id") on delete set null
);
CREATE INDEX "bank_transactions_reconcilable_type_reconcilable_id_index" on "bank_transactions"(
  "reconcilable_type",
  "reconcilable_id"
);
CREATE INDEX "bank_transactions_bank_reference_index" on "bank_transactions"(
  "bank_reference"
);
CREATE INDEX "bank_transactions_transaction_date_index" on "bank_transactions"(
  "transaction_date"
);
CREATE UNIQUE INDEX "bank_transactions_bank_account_id_provider_transaction_id_unique" on "bank_transactions"(
  "bank_account_id",
  "provider_transaction_id"
);
CREATE TABLE IF NOT EXISTS "accounting_journals"(
  "id" integer primary key autoincrement not null,
  "code" varchar not null,
  "name" varchar not null,
  "type" varchar not null,
  "plan_comptable_id" integer,
  "is_active" tinyint(1) not null default '1',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("plan_comptable_id") references "plan_comptables"("id") on delete set null
);
CREATE UNIQUE INDEX "accounting_journals_code_unique" on "accounting_journals"(
  "code"
);
CREATE TABLE IF NOT EXISTS "accounting_entries"(
  "id" integer primary key autoincrement not null,
  "journal_id" integer not null,
  "sourceable_type" varchar not null,
  "sourceable_id" integer not null,
  "entry_date" date not null,
  "reference" varchar,
  "label" varchar not null,
  "fiscal_year" integer not null,
  "status" varchar not null default 'draft',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("journal_id") references "accounting_journals"("id") on delete restrict
);
CREATE INDEX "accounting_entries_sourceable_type_sourceable_id_index" on "accounting_entries"(
  "sourceable_type",
  "sourceable_id"
);
CREATE INDEX "accounting_entries_entry_date_index" on "accounting_entries"(
  "entry_date"
);
CREATE INDEX "accounting_entries_fiscal_year_index" on "accounting_entries"(
  "fiscal_year"
);
CREATE TABLE IF NOT EXISTS "accounting_entry_lines"(
  "id" integer primary key autoincrement not null,
  "entry_id" integer not null,
  "plan_comptable_id" integer not null,
  "tiers_id" integer,
  "label" varchar not null,
  "debit" numeric not null default '0',
  "credit" numeric not null default '0',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("entry_id") references "accounting_entries"("id") on delete cascade,
  foreign key("plan_comptable_id") references "plan_comptables"("id") on delete restrict,
  foreign key("tiers_id") references "tiers"("id") on delete set null
);
CREATE UNIQUE INDEX "accounting_entry_lines_plan_comptable_id_tiers_id_unique" on "accounting_entry_lines"(
  "plan_comptable_id",
  "tiers_id"
);
CREATE TABLE IF NOT EXISTS "employee_profiles"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "social_security_number" varchar,
  "birth_date" date,
  "nationnality" varchar,
  "phone" varchar,
  "address" varchar,
  "code_postal" varchar,
  "ville" varchar,
  "pays" varchar,
  "hired_at" date not null,
  "left_at" date,
  "bank_iban" varchar,
  "emergency_contact_name" varchar,
  "emergency_contact_phone" varchar,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete cascade
);
CREATE UNIQUE INDEX "employee_profiles_user_id_unique" on "employee_profiles"(
  "user_id"
);
CREATE TABLE IF NOT EXISTS "employee_contracts"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "contract_type" varchar not null,
  "job_title" varchar not null,
  "job_description" text,
  "start_at" date not null,
  "end_at" date,
  "base_salary" numeric not null,
  "salary_period" varchar not null default 'monthly',
  "weekly_hours" numeric not null default '35',
  "is_active" tinyint(1) not null default '1',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "employee_qualifications"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "name" varchar not null,
  "issued_by" varchar,
  "issued_at" date not null,
  "expired_at" date,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "leave_entitlements"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "year" varchar not null,
  "type" varchar not null,
  "total_allocated" numeric not null,
  "total_taken" numeric not null default '0',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete cascade
);
CREATE UNIQUE INDEX "leave_entitlements_user_id_year_type_unique" on "leave_entitlements"(
  "user_id",
  "year",
  "type"
);
CREATE TABLE IF NOT EXISTS "performance_reviews"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "reviewer_id" integer not null,
  "review_date" date not null,
  "rating" integer,
  "strengths" text,
  "weaknesses" text,
  "goals" text,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete cascade,
  foreign key("reviewer_id") references "users"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "employee_documents"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "name" varchar not null,
  "type" varchar not null,
  "file_path" varchar not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "payroll_components"(
  "id" integer primary key autoincrement not null,
  "code" varchar not null,
  "name" varchar not null,
  "type" varchar not null,
  "calculation_method" varchar not null default 'fixed',
  "rate" numeric,
  "fixed_amount" numeric,
  "base_component_code" varchar,
  "is_active" tinyint(1) not null default '1'
);
CREATE UNIQUE INDEX "payroll_components_code_unique" on "payroll_components"(
  "code"
);
CREATE TABLE IF NOT EXISTS "payroll_variables"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "component_id" integer not null,
  "applicable_date" date not null,
  "value" numeric not null,
  "unit" varchar not null default 'amount',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete cascade,
  foreign key("component_id") references "payroll_components"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "pay_slips"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "employee_contract_id" integer,
  "period_year" varchar not null,
  "period_month" varchar not null,
  "period_start_at" date not null,
  "period_end_at" date not null,
  "status" varchar not null default 'draft',
  "total_gross_salary" numeric not null,
  "total_salary_deductions" numeric not null,
  "total_employer_contributions" numeric not null,
  "net_salary" numeric not null,
  "net_payable" numeric not null,
  "document_path" varchar,
  "employee_document_id" integer,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete cascade,
  foreign key("employee_contract_id") references "employee_contracts"("id") on delete set null,
  foreign key("employee_document_id") references "employee_documents"("id") on delete set null
);
CREATE TABLE IF NOT EXISTS "pay_slip_lines"(
  "id" integer primary key autoincrement not null,
  "pay_slip_id" integer not null,
  "component_code" varchar not null,
  "label" varchar not null,
  "type" varchar not null,
  "base_amount" numeric,
  "rate" numeric,
  "gain_amount" numeric,
  "deduction_amount" numeric,
  "employer_amount" numeric,
  "order" integer not null default '0',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("pay_slip_id") references "pay_slips"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "expense_categories"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "code" varchar,
  "plan_comptable_id" integer,
  "requires_receipt" tinyint(1) not null default '1',
  "is_active" tinyint(1) not null default '1',
  foreign key("plan_comptable_id") references "plan_comptables"("id") on delete set null
);
CREATE TABLE IF NOT EXISTS "expense_reports"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "manager_id" integer,
  "title" varchar not null,
  "status" varchar not null default 'draft',
  "period_start_date" date,
  "period_end_date" date,
  "total_ht" numeric not null default '0',
  "total_ttc" numeric not null default '0',
  "submitted_at" datetime,
  "approved_at" datetime,
  "rejected_at" datetime,
  "payed_at" datetime,
  "rejection_reason" text,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete cascade,
  foreign key("manager_id") references "users"("id") on delete set null
);
CREATE TABLE IF NOT EXISTS "expenses"(
  "id" integer primary key autoincrement not null,
  "expense_report_id" integer not null,
  "expense_category_id" integer not null,
  "expense_date" date not null,
  "description" text not null,
  "amount_ht" numeric not null,
  "vat_rate" numeric,
  "amount_vat" numeric,
  "amount_ttc" numeric not null,
  "currency" varchar not null default 'EUR',
  "notes" text,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("expense_report_id") references "expense_reports"("id") on delete cascade,
  foreign key("expense_category_id") references "expense_categories"("id") on delete restrict
);
CREATE TABLE IF NOT EXISTS "expense_receipts"(
  "id" integer primary key autoincrement not null,
  "expense_id" integer not null,
  "file_path" varchar not null,
  "filename" varchar not null,
  "mime_type" varchar,
  "size" integer,
  "ocr_raw_text" text,
  "ocr_detected_amount" numeric,
  "ocr_detected_date" date,
  "ocr_detected_merchant" varchar,
  "ocr_status" varchar not null default 'pending',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("expense_id") references "expenses"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "production_lines"(
  "id" integer primary key autoincrement not null,
  "code" varchar not null,
  "name" varchar not null,
  "description" text,
  "is_active" tinyint(1) not null default '1'
);
CREATE UNIQUE INDEX "production_lines_code_unique" on "production_lines"(
  "code"
);
CREATE TABLE IF NOT EXISTS "production_orders"(
  "id" integer primary key autoincrement not null,
  "number" varchar not null,
  "articles_id" integer not null,
  "quantity_to_produce" numeric not null,
  "quantity_produced" numeric not null default '0',
  "chantiers_id" integer,
  "commande_id" integer,
  "due_date" date not null,
  "started_at" datetime,
  "completed_at" datetime,
  "status" varchar not null default 'draft',
  "estimated_coast" numeric,
  "actual_coast" numeric,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("articles_id") references "articles"("id") on delete restrict,
  foreign key("chantiers_id") references "chantiers"("id") on delete set null,
  foreign key("commande_id") references "commandes"("id") on delete set null
);
CREATE UNIQUE INDEX "production_orders_number_unique" on "production_orders"(
  "number"
);
CREATE TABLE IF NOT EXISTS "production_order_components"(
  "id" integer primary key autoincrement not null,
  "production_order_id" integer not null,
  "articles_id" integer not null,
  "quantity_required" numeric not null,
  "quantity_consumed" numeric not null default '0',
  "unit_cost" varchar,
  foreign key("production_order_id") references "production_orders"("id") on delete cascade,
  foreign key("articles_id") references "articles"("id") on delete restrict
);
CREATE TABLE IF NOT EXISTS "production_order_operations"(
  "id" integer primary key autoincrement not null,
  "production_order_id" integer not null,
  "user_id" integer,
  "production_line_id" integer,
  "description" text,
  "time_spent_hours" numeric not null default '0',
  "hourly_cost" numeric,
  "started_at" datetime,
  "ended_at" datetime,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("production_order_id") references "production_orders"("id") on delete cascade,
  foreign key("user_id") references "users"("id") on delete set null,
  foreign key("production_line_id") references "production_lines"("id") on delete set null
);
CREATE TABLE IF NOT EXISTS "document_collections"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "description" text,
  "is_public" tinyint(1) not null default '0',
  "parent_id" integer,
  foreign key("parent_id") references "document_collections"("id") on delete set null
);
CREATE TABLE IF NOT EXISTS "documents"(
  "id" integer primary key autoincrement not null,
  "user_id" integer,
  "document_collection_id" integer,
  "documentable_type" varchar not null,
  "documentable_id" integer not null,
  "name" varchar not null,
  "status" varchar not null default 'active',
  "current_file_path" varchar not null,
  "current_filename" varchar not null,
  "current_mime_type" varchar,
  "current_size" integer,
  "current_version_number" integer not null default '1',
  "is_signed" tinyint(1) not null,
  "signed_at" datetime,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete set null,
  foreign key("document_collection_id") references "document_collections"("id") on delete set null
);
CREATE INDEX "documents_documentable_type_documentable_id_index" on "documents"(
  "documentable_type",
  "documentable_id"
);
CREATE INDEX "documents_documentable_id_documentable_type_index" on "documents"(
  "documentable_id",
  "documentable_type"
);
CREATE TABLE IF NOT EXISTS "document_versions"(
  "id" integer primary key autoincrement not null,
  "document_id" integer not null,
  "user_id" integer,
  "version_number" integer not null,
  "file_path" varchar not null,
  "filename" varchar not null,
  "mime_type" varchar,
  "size" integer,
  "notes" text,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("document_id") references "documents"("id") on delete cascade,
  foreign key("user_id") references "users"("id") on delete set null
);
CREATE TABLE IF NOT EXISTS "tags"(
  "id" integer primary key autoincrement not null,
  "name" text not null,
  "slug" text not null,
  "type" varchar,
  "order_column" integer,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE TABLE IF NOT EXISTS "taggables"(
  "tag_id" integer not null,
  "taggable_type" varchar not null,
  "taggable_id" integer not null,
  foreign key("tag_id") references "tags"("id") on delete cascade
);
CREATE INDEX "taggables_taggable_type_taggable_id_index" on "taggables"(
  "taggable_type",
  "taggable_id"
);
CREATE UNIQUE INDEX "taggables_tag_id_taggable_id_taggable_type_unique" on "taggables"(
  "tag_id",
  "taggable_id",
  "taggable_type"
);
CREATE TABLE IF NOT EXISTS "signature_procedures"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "document_id" integer not null,
  "subject" varchar,
  "message" text,
  "status" varchar not null default 'draft',
  "ordering_enabled" tinyint(1) not null default '0',
  "sent_at" datetime,
  "completed_at" datetime,
  "expires_at" datetime,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete cascade,
  foreign key("document_id") references "documents"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "signature_signers"(
  "id" integer primary key autoincrement not null,
  "procedure_id" integer not null,
  "email" varchar not null,
  "name" varchar not null,
  "status" varchar not null default 'pending',
  "order" integer not null,
  "token" varchar not null,
  "sent_at" datetime,
  "viewed_at" datetime,
  "signed_at" datetime,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("procedure_id") references "signature_procedures"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "signature_logs"(
  "id" integer primary key autoincrement not null,
  "procedure_id" integer not null,
  "signer_id" integer,
  "event_type" varchar not null,
  "ip_address" varchar,
  "user_agent" text,
  "detail" text,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("procedure_id") references "signature_procedures"("id") on delete cascade,
  foreign key("signer_id") references "signature_signers"("id") on delete set null
);
CREATE TABLE IF NOT EXISTS "signature_quotas"(
  "id" integer primary key autoincrement not null,
  "total_allocated" integer not null default '0',
  "total_used" integer not null default '0'
);
CREATE TABLE IF NOT EXISTS "vehicules"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "plate_number" varchar,
  "vin_number" varchar,
  "brand" varchar,
  "model" varchar,
  "type" varchar not null default 'vehicle',
  "status" varchar not null default 'active',
  "purchased_at" date,
  "purchase_price" numeric,
  "toll_badge_number" varchar,
  "created_at" datetime,
  "updated_at" datetime,
  "deleted_at" datetime
);
CREATE UNIQUE INDEX "vehicules_plate_number_unique" on "vehicules"(
  "plate_number"
);
CREATE UNIQUE INDEX "vehicules_vin_number_unique" on "vehicules"("vin_number");
CREATE UNIQUE INDEX "vehicules_toll_badge_number_unique" on "vehicules"(
  "toll_badge_number"
);
CREATE TABLE IF NOT EXISTS "vehicle_contracts"(
  "id" integer primary key autoincrement not null,
  "vehicule_id" integer not null,
  "type" varchar not null,
  "provider_name" varchar,
  "contract_number" varchar,
  "cost_amount" numeric,
  "cost_frequency" varchar,
  "started_at" date not null,
  "expires_at" date,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("vehicule_id") references "vehicules"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "vehicle_maintenances"(
  "id" integer primary key autoincrement not null,
  "vehicule_id" integer not null,
  "type" varchar not null,
  "description" varchar not null,
  "schedule_at" date,
  "completed_at" date,
  "cost_amount" numeric,
  "provider_name" varchar,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("vehicule_id") references "vehicules"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "vehicle_usage_logs"(
  "id" integer primary key autoincrement not null,
  "vehicule_id" integer not null,
  "user_id" integer,
  "chantiers_id" integer,
  "log_date" datetime not null,
  "mileage_start" integer,
  "mileage_end" integer,
  "hours_start" integer,
  "hours_end" integer,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("vehicule_id") references "vehicules"("id") on delete cascade,
  foreign key("user_id") references "users"("id") on delete set null,
  foreign key("chantiers_id") references "chantiers"("id") on delete set null
);
CREATE TABLE IF NOT EXISTS "vehicle_toll_logs"(
  "id" integer primary key autoincrement not null,
  "vehicule_id" integer not null,
  "chantiers_id" integer,
  "transaction_date" datetime not null,
  "amount" numeric not null,
  "peage" varchar,
  "direction" varchar,
  "provider" varchar not null default 'ulys',
  "provider_transaction_id" varchar not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("vehicule_id") references "vehicules"("id") on delete cascade,
  foreign key("chantiers_id") references "chantiers"("id") on delete set null
);
CREATE UNIQUE INDEX "vehicle_toll_logs_provider_transaction_id_unique" on "vehicle_toll_logs"(
  "provider_transaction_id"
);
CREATE TABLE IF NOT EXISTS "rental_contracts"(
  "id" integer primary key autoincrement not null,
  "tiers_id" integer not null,
  "chantiers_id" integer,
  "number" varchar not null,
  "status" varchar not null default 'draft',
  "start_date" datetime not null,
  "end_date" datetime not null,
  "billing_frequency" varchar not null default 'daily',
  "last_billed_at" date,
  "total_amount" varchar,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("tiers_id") references "tiers"("id") on delete cascade,
  foreign key("chantiers_id") references "chantiers"("id") on delete restrict
);
CREATE UNIQUE INDEX "rental_contracts_number_unique" on "rental_contracts"(
  "number"
);
CREATE TABLE IF NOT EXISTS "rental_contract_lines"(
  "id" integer primary key autoincrement not null,
  "rental_contract_id" integer not null,
  "rentable_type" varchar not null,
  "rentable_id" integer not null,
  "description" varchar not null,
  "quantity" numeric not null,
  "unit_price" numeric not null,
  "price_unit" varchar not null,
  "total_line_amount" numeric not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("rental_contract_id") references "rental_contracts"("id") on delete cascade
);
CREATE INDEX "rental_contract_lines_rentable_type_rentable_id_index" on "rental_contract_lines"(
  "rentable_type",
  "rentable_id"
);
CREATE TABLE IF NOT EXISTS "rental_availabilities"(
  "id" integer primary key autoincrement not null,
  "rental_contract_id" integer not null,
  "rentable_type" varchar not null,
  "rentable_id" integer not null,
  "start_date" datetime not null,
  "end_date" datetime not null,
  "quantity_reserved" numeric not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("rental_contract_id") references "rental_contracts"("id") on delete cascade
);
CREATE INDEX "rental_availabilities_rentable_type_rentable_id_index" on "rental_availabilities"(
  "rentable_type",
  "rentable_id"
);
CREATE INDEX "rental_availability_index" on "rental_availabilities"(
  "rentable_type",
  "rentable_id",
  "start_date",
  "end_date"
);
CREATE TABLE IF NOT EXISTS "rental_returns"(
  "id" integer primary key autoincrement not null,
  "rental_contract_id" integer not null,
  "user_id" integer,
  "returned_at" datetime not null,
  "condition_notes" text,
  "additional_costs" numeric,
  "additional_costs_notes" text,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("rental_contract_id") references "rental_contracts"("id") on delete cascade,
  foreign key("user_id") references "users"("id") on delete set null
);
CREATE TABLE IF NOT EXISTS "bim_models"(
  "id" integer primary key autoincrement not null,
  "chantiers_id" integer not null,
  "name" varchar not null,
  "source_file_path" varchar not null,
  "source_file_type" varchar not null,
  "web_viewable_file_path" varchar,
  "processing_status" varchar not null default 'pending',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("chantiers_id") references "chantiers"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "bim_object_metadata"(
  "id" integer primary key autoincrement not null,
  "bim_model_id" integer not null,
  "object_guid" varchar not null,
  "object_type" varchar,
  "name" varchar,
  "properties" text,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("bim_model_id") references "bim_models"("id") on delete cascade
);
CREATE UNIQUE INDEX "bim_object_metadata_bim_model_id_object_guid_unique" on "bim_object_metadata"(
  "bim_model_id",
  "object_guid"
);
CREATE TABLE IF NOT EXISTS "bim_links"(
  "id" integer primary key autoincrement not null,
  "bim_object_id" integer not null,
  "linkable_type" varchar not null,
  "linkable_id" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("bim_object_id") references "bim_models"("id") on delete cascade
);
CREATE INDEX "bim_links_linkable_type_linkable_id_index" on "bim_links"(
  "linkable_type",
  "linkable_id"
);
CREATE UNIQUE INDEX "bim_link_unique_index" on "bim_links"(
  "bim_object_id",
  "linkable_id",
  "linkable_type"
);

INSERT INTO migrations VALUES(1,'0001_01_01_000000_create_users_table',1);
INSERT INTO migrations VALUES(2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO migrations VALUES(3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO migrations VALUES(4,'2024_01_01_000001_create_schedules_table',1);
INSERT INTO migrations VALUES(5,'2024_01_01_000002_create_schedule_periods_table',1);
INSERT INTO migrations VALUES(6,'2024_01_01_000003_add_schedule_type_to_schedules_table',1);
INSERT INTO migrations VALUES(7,'2025_09_22_145432_add_two_factor_columns_to_users_table',1);
INSERT INTO migrations VALUES(8,'2025_10_11_223023_create_modules_table',1);
INSERT INTO migrations VALUES(9,'2025_10_11_223430_create_options_table',1);
INSERT INTO migrations VALUES(10,'2025_10_11_223437_create_services_table',1);
INSERT INTO migrations VALUES(11,'2025_10_16_194531_create_cities_table',1);
INSERT INTO migrations VALUES(12,'2025_10_16_200142_create_countries_table',1);
INSERT INTO migrations VALUES(13,'2025_10_16_200459_create_plan_comptables_table',1);
INSERT INTO migrations VALUES(14,'2025_10_16_201205_create_companies_table',1);
INSERT INTO migrations VALUES(15,'2025_10_16_202524_create_banks_table',1);
INSERT INTO migrations VALUES(16,'2025_10_17_130557_create_condition_reglements_table',1);
INSERT INTO migrations VALUES(17,'2025_10_17_130847_create_mode_reglements_table',1);
INSERT INTO migrations VALUES(18,'2025_11_01_195109_create_personal_access_tokens_table',1);
INSERT INTO migrations VALUES(19,'2025_11_01_200421_create_notifications_table',1);
INSERT INTO migrations VALUES(20,'2025_11_02_000000_create_warehouses_table',1);
INSERT INTO migrations VALUES(21,'2025_11_09_192206_create_tiers_table',1);
INSERT INTO migrations VALUES(22,'2025_11_09_194030_create_tiers_addresses_table',1);
INSERT INTO migrations VALUES(23,'2025_11_09_195856_create_tiers_contacts_table',1);
INSERT INTO migrations VALUES(24,'2025_11_09_200240_create_tiers_supplies_table',1);
INSERT INTO migrations VALUES(25,'2025_11_09_200620_create_tiers_customers_table',1);
INSERT INTO migrations VALUES(26,'2025_11_09_200904_create_tiers_logs_table',1);
INSERT INTO migrations VALUES(27,'2025_11_09_201111_create_tiers_banks_table',1);
INSERT INTO migrations VALUES(28,'2025_11_10_000000_create_units_table',1);
INSERT INTO migrations VALUES(29,'2025_11_10_000001_create_article_categories_table',1);
INSERT INTO migrations VALUES(30,'2025_11_10_000002_create_articles_table',1);
INSERT INTO migrations VALUES(31,'2025_11_10_000003_create_article_prices_table',1);
INSERT INTO migrations VALUES(32,'2025_11_10_000004_create_article_stocks_table',1);
INSERT INTO migrations VALUES(33,'2025_11_10_000005_create_article_ouvrages_table',1);
INSERT INTO migrations VALUES(34,'2025_11_10_225856_create_chantiers_table',1);
INSERT INTO migrations VALUES(35,'2025_11_10_230440_create_chantiers_tasks_table',1);
INSERT INTO migrations VALUES(36,'2025_11_10_231021_create_chantiers_depenses_table',1);
INSERT INTO migrations VALUES(37,'2025_11_10_231404_create_chantiers_interventions_table',1);
INSERT INTO migrations VALUES(38,'2025_11_10_231829_create_chantiers_addresses_table',1);
INSERT INTO migrations VALUES(39,'2025_11_10_232057_create_chantiers_user_table',1);
INSERT INTO migrations VALUES(40,'2025_11_10_232256_create_chantiers_logs_table',1);
INSERT INTO migrations VALUES(41,'2025_11_10_235000_create_chantiers_postes_table',1);
INSERT INTO migrations VALUES(42,'2025_11_11_140543_create_devis_table',1);
INSERT INTO migrations VALUES(43,'2025_11_11_141151_create_devis_lignes_table',1);
INSERT INTO migrations VALUES(44,'2025_11_11_141724_create_commandes_table',1);
INSERT INTO migrations VALUES(45,'2025_11_11_142221_create_commande_lignes_table',1);
INSERT INTO migrations VALUES(46,'2025_11_11_155516_create_settings_table',1);
INSERT INTO migrations VALUES(47,'2025_11_11_162713_create_factures_table',1);
INSERT INTO migrations VALUES(48,'2025_11_11_164828_create_facture_lignes_table',1);
INSERT INTO migrations VALUES(49,'2025_11_11_180010_create_payments_table',1);
INSERT INTO migrations VALUES(50,'2025_11_11_180417_create_facture_payment_table',1);
INSERT INTO migrations VALUES(51,'2025_11_11_180853_create_facture_recurrings_table',1);
INSERT INTO migrations VALUES(52,'2025_11_11_181706_create_facture_reminders_table',1);
INSERT INTO migrations VALUES(53,'2025_11_11_195924_create_bank_connections_table',1);
INSERT INTO migrations VALUES(54,'2025_11_11_200518_create_bank_accounts_table',1);
INSERT INTO migrations VALUES(55,'2025_11_11_201308_create_bank_transactions_table',1);
INSERT INTO migrations VALUES(56,'2025_11_11_203019_create_accounting_journals_table',1);
INSERT INTO migrations VALUES(57,'2025_11_11_203330_create_accounting_entries_table',1);
INSERT INTO migrations VALUES(58,'2025_11_11_203542_create_accounting_entry_lines_table',1);
INSERT INTO migrations VALUES(59,'2025_11_11_212722_create_employee_profiles_table',1);
INSERT INTO migrations VALUES(60,'2025_11_11_213102_create_employee_contracts_table',1);
INSERT INTO migrations VALUES(61,'2025_11_11_213424_create_employee_qualifications_table',1);
INSERT INTO migrations VALUES(62,'2025_11_11_213659_create_leave_entitlements_table',1);
INSERT INTO migrations VALUES(63,'2025_11_11_214113_create_performance_reviews_table',1);
INSERT INTO migrations VALUES(64,'2025_11_11_214303_create_employee_documents_table',1);
INSERT INTO migrations VALUES(65,'2025_11_11_220000_create_payroll_components_table',1);
INSERT INTO migrations VALUES(66,'2025_11_11_220408_create_payroll_variables_table',1);
INSERT INTO migrations VALUES(67,'2025_11_11_220751_create_pay_slips_table',1);
INSERT INTO migrations VALUES(68,'2025_11_11_221209_create_pay_slip_lines_table',1);
INSERT INTO migrations VALUES(69,'2025_11_11_223233_create_expense_categories_table',1);
INSERT INTO migrations VALUES(70,'2025_11_11_223641_create_expense_reports_table',1);
INSERT INTO migrations VALUES(71,'2025_11_11_224023_create_expenses_table',1);
INSERT INTO migrations VALUES(72,'2025_11_11_224342_create_expense_receipts_table',1);
INSERT INTO migrations VALUES(73,'2025_11_11_232034_create_production_lines_table',1);
INSERT INTO migrations VALUES(74,'2025_11_11_232410_create_production_orders_table',1);
INSERT INTO migrations VALUES(75,'2025_11_11_232817_create_production_order_components_table',1);
INSERT INTO migrations VALUES(76,'2025_11_11_233237_create_production_order_operations_table',1);
INSERT INTO migrations VALUES(77,'2025_11_12_004411_create_document_collections_table',1);
INSERT INTO migrations VALUES(78,'2025_11_12_004733_create_documents_table',1);
INSERT INTO migrations VALUES(79,'2025_11_12_005129_create_document_versions_table',1);
INSERT INTO migrations VALUES(80,'2025_11_12_005306_create_tag_tables',1);
INSERT INTO migrations VALUES(81,'2025_11_12_011509_create_signature_procedures_table',1);
INSERT INTO migrations VALUES(82,'2025_11_12_011758_create_signature_signers_table',1);
INSERT INTO migrations VALUES(83,'2025_11_12_012018_create_signature_logs_table',1);
INSERT INTO migrations VALUES(84,'2025_11_12_012215_create_signature_quotas_table',1);
INSERT INTO migrations VALUES(85,'2025_11_12_141115_create_vehicules_table',1);
INSERT INTO migrations VALUES(86,'2025_11_12_141507_create_vehicle_contracts_table',1);
INSERT INTO migrations VALUES(87,'2025_11_12_142339_create_vehicle_maintenances_table',1);
INSERT INTO migrations VALUES(88,'2025_11_12_142740_create_vehicle_usage_logs_table',1);
INSERT INTO migrations VALUES(89,'2025_11_12_143043_create_vehicle_toll_logs_table',1);
INSERT INTO migrations VALUES(90,'2025_11_12_151054_create_rental_contracts_table',1);
INSERT INTO migrations VALUES(91,'2025_11_12_151430_create_rental_contract_lines_table',1);
INSERT INTO migrations VALUES(92,'2025_11_12_151641_create_rental_availabilities_table',1);
INSERT INTO migrations VALUES(93,'2025_11_12_151901_create_rental_returns_table',1);
INSERT INTO migrations VALUES(94,'2025_11_12_161141_create_bim_models_table',1);
INSERT INTO migrations VALUES(95,'2025_11_12_161937_create_bim_object_metadata_table',1);
INSERT INTO migrations VALUES(96,'2025_11_12_162450_create_bim_links_table',1);
