-- DROP SCHEMA seg;

CREATE SCHEMA seg AUTHORIZATION postgres;

-- seg.roles definition

-- Drop table

-- DROP TABLE roles;

CREATE TABLE seg.roles (
	rol_id int4 NOT NULL,
	nombre varchar NULL,
	descripcion varchar NULL,
	fec_alta date NULL,
	eliminado int2 NOT NULL DEFAULT 0
);


-- seg.settings definition

-- Drop table

-- DROP TABLE settings;

CREATE TABLE seg.settings (
	id serial NOT NULL,
	site_title varchar(50) NOT NULL,
	timezone varchar(100) NOT NULL,
	recaptcha varchar(5) NOT NULL,
	theme varchar(100) NOT NULL
);


-- seg.tokens definition

-- Drop table

-- DROP TABLE tokens;

CREATE TABLE seg.tokens (
	id serial NOT NULL,
	"token" varchar(255) NOT NULL,
	user_id int8 NOT NULL,
	created date NOT NULL,
	CONSTRAINT tokens_pk PRIMARY KEY (id)
);


-- seg.users definition

-- Drop table

-- DROP TABLE users;

CREATE TABLE seg.users (
	id serial NOT NULL,
	email varchar(100) NULL,
	first_name varchar(100) NULL,
	last_name varchar(100) NULL,
	"role" varchar(10) NULL,
	"password" text NULL,
	last_login varchar(100) NULL,
	status varchar(100) NULL,
	banned_users varchar(100) NULL,
	passmd5 text NULL,
	telefono varchar NULL,
	dni varchar NULL,
	usernick varchar NULL,
	depo_id int4 NULL,
	CONSTRAINT users_pk PRIMARY KEY (id),
	CONSTRAINT users_un UNIQUE (email)
);


-- seg.memberships_users definition

-- Drop table

-- DROP TABLE memberships_users;

CREATE TABLE seg.memberships_users (
	"group" varchar NOT NULL,
	"role" varchar NOT NULL,
	fec_alta varchar NOT NULL DEFAULT now(),
	usuario varchar NOT NULL DEFAULT CURRENT_USER,
	usuario_app varchar NOT NULL,
	email varchar NOT NULL,
	CONSTRAINT memberships_pk PRIMARY KEY ("group", role, email),
	CONSTRAINT memberships_users_fk FOREIGN KEY (email) REFERENCES seg.users(email)
);


-- seg.menues definition

-- Drop table

-- DROP TABLE menues;

CREATE TABLE seg.menues (
	modulo varchar(4) NOT NULL,
	opcion varchar NOT NULL,
	texto varchar NOT NULL,
	url varchar NULL,
	javascript varchar NULL,
	orden int4 NULL DEFAULT 0,
	url_icono varchar NULL,
	texto_onmouseover varchar NULL,
	eliminado int2 NULL DEFAULT 0,
	fec_alta varchar NOT NULL DEFAULT now(),
	usuario varchar NOT NULL DEFAULT CURRENT_USER,
	usuario_app varchar NOT NULL,
	opcion_padre varchar NULL,
	CONSTRAINT menues_check CHECK ((((modulo)::text = 'PRD'::text) OR ((modulo)::text = 'CORE'::text) OR ((modulo)::text = 'ALM'::text) OR ((modulo)::text = 'MAN'::text) OR ((modulo)::text = 'TAR'::text) OR ((modulo)::text = 'PAN'::text) OR ((modulo)::text = 'LOG'::text) OR ((modulo)::text = 'SEG'::text) OR ((modulo)::text = 'TRZ'::text) OR ((modulo)::text = 'PRO'::text) OR ((modulo)::text = 'FIS'::text))),
	CONSTRAINT menues_pk PRIMARY KEY (modulo, opcion),
	CONSTRAINT menues_opcion_padre_fk FOREIGN KEY (modulo, opcion_padre) REFERENCES seg.menues(modulo, opcion)
);


-- seg.memberships_menues definition

-- Drop table

-- DROP TABLE memberships_menues;

CREATE TABLE seg.memberships_menues (
	modulo varchar NOT NULL,
	opcion varchar NOT NULL,
	"group" varchar NULL,
	"role" varchar NULL,
	fec_alta date NOT NULL DEFAULT now(),
	usuario varchar NOT NULL DEFAULT CURRENT_USER,
	usuario_app varchar NOT NULL,
	CONSTRAINT memberships_menues_modulo_opcion_fk FOREIGN KEY (modulo, opcion) REFERENCES seg.menues(modulo, opcion)
);