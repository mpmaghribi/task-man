--
-- PostgreSQL database dump
--

-- Dumped from database version 9.3.3
-- Dumped by pg_dump version 9.3.3
-- Started on 2014-03-21 00:10:25

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

DROP DATABASE "taskman";
--
-- TOC entry 2025 (class 1262 OID 24608)
-- Name: taskman; Type: DATABASE; Schema: -; Owner: postgres
--

CREATE DATABASE "taskman" WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'English_United Kingdom.1252' LC_CTYPE = 'English_United Kingdom.1252';


ALTER DATABASE "taskman" OWNER TO "postgres";

\connect "taskman"

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 5 (class 2615 OID 2200)
-- Name: public; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA "public";


ALTER SCHEMA "public" OWNER TO "postgres";

--
-- TOC entry 2026 (class 0 OID 0)
-- Dependencies: 5
-- Name: SCHEMA "public"; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA "public" IS 'standard public schema';


--
-- TOC entry 179 (class 3079 OID 11750)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS "plpgsql" WITH SCHEMA "pg_catalog";


--
-- TOC entry 2028 (class 0 OID 0)
-- Dependencies: 179
-- Name: EXTENSION "plpgsql"; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION "plpgsql" IS 'PL/pgSQL procedural language';


SET search_path = "public", pg_catalog;

--
-- TOC entry 193 (class 1255 OID 24956)
-- Name: function_login(character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION "function_login"("f_username" character varying, "f_pwd" character varying) RETURNS character varying
    LANGUAGE "plpgsql"
    AS $$declare
kode character varying(255);
pesan character varying(255);
rnip character varying(255);
BEGIN
	IF (SELECT 1 FROM akun WHERE nip = f_username AND akun_password = f_pwd) THEN
		SELECT 1, 'Login Sukses',nip into kode, pesan, rnip FROM akun WHERE nip = f_username AND akun_password = f_pwd;
	ELSE 
		SELECT -1, 'Login Gagal' into kode, pesan;
	END IF;
	return kode;
END;$$;


ALTER FUNCTION "public"."function_login"("f_username" character varying, "f_pwd" character varying) OWNER TO "postgres";

--
-- TOC entry 192 (class 1255 OID 24953)
-- Name: tes(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION "tes"("angka" integer) RETURNS integer
    LANGUAGE "plpgsql"
    AS $$begin
	return angka +100;
end;$$;


ALTER FUNCTION "public"."tes"("angka" integer) OWNER TO "postgres";

SET default_with_oids = false;

--
-- TOC entry 170 (class 1259 OID 24820)
-- Name: activity; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "activity" (
    "id_activity" integer NOT NULL,
    "id_akun" integer,
    "id_detil_pekerjaan" integer,
    "nama_activity" character varying(50),
    "deskripsi_activity" "text",
    "tanggal_activity" "date"
);


ALTER TABLE "public"."activity" OWNER TO "postgres";

--
-- TOC entry 171 (class 1259 OID 24831)
-- Name: akun; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "akun" (
    "id_akun" integer NOT NULL,
    "id_jabatan" integer,
    "id_departemen" integer,
    "nip" character varying(50),
    "nama" character varying(50),
    "alamat" character varying(100),
    "jenis_kelamin" character varying(2),
    "agama" character varying(15),
    "telepon" character varying(25),
    "hp" character varying(25),
    "email" character varying(25),
    "akun_password" character varying(25)
);


ALTER TABLE "public"."akun" OWNER TO "postgres";

--
-- TOC entry 172 (class 1259 OID 24839)
-- Name: departemen; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "departemen" (
    "id_departemen" integer NOT NULL,
    "nama_departemen" character varying(50)
);


ALTER TABLE "public"."departemen" OWNER TO "postgres";

--
-- TOC entry 173 (class 1259 OID 24845)
-- Name: detil_pekerjaan; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "detil_pekerjaan" (
    "id_detil_pekerjaan" integer NOT NULL,
    "id_pekerjaan" integer,
    "id_akun" integer,
    "consignee" integer,
    "pemberi_pekerjaan" integer,
    "tgl_read" "date",
    "tglasli_mulai" "date",
    "tglaslli_selesai" "date",
    "skor" integer,
    "progress" integer
);


ALTER TABLE "public"."detil_pekerjaan" OWNER TO "postgres";

--
-- TOC entry 174 (class 1259 OID 24853)
-- Name: file; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "file" (
    "id_file" integer NOT NULL,
    "id_pekerjaan" integer,
    "nama_file" character varying(100)
);


ALTER TABLE "public"."file" OWNER TO "postgres";

--
-- TOC entry 175 (class 1259 OID 24860)
-- Name: jabatan; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "jabatan" (
    "id_jabatan" integer NOT NULL,
    "nama_jabatan" character varying(50)
);


ALTER TABLE "public"."jabatan" OWNER TO "postgres";

--
-- TOC entry 176 (class 1259 OID 24866)
-- Name: komentar; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "komentar" (
    "id_komentar" integer NOT NULL,
    "id_akun" integer,
    "id_pekerjaan" integer,
    "isi_komentar" "text"
);


ALTER TABLE "public"."komentar" OWNER TO "postgres";

--
-- TOC entry 177 (class 1259 OID 24877)
-- Name: pekerjaan; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "pekerjaan" (
    "id_pekerjaan" integer NOT NULL,
    "id_sifat_pekerjaan" integer,
    "parent_pekerjaan" integer,
    "nama_pekerjaan" character varying(50),
    "deskripsi_pekerjaan" "text",
    "tgl_mulai" "date",
    "tgl_selesai" "date",
    "status_pekerjaan" character varying(25),
    "asal_pekerjaan" character varying(50),
    "level_prioritas" integer
);


ALTER TABLE "public"."pekerjaan" OWNER TO "postgres";

--
-- TOC entry 178 (class 1259 OID 24887)
-- Name: sifat_pekerjaan; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "sifat_pekerjaan" (
    "id_sifat_pekerjaan" integer NOT NULL,
    "nama_sifat_pekerjaan" character varying(50)
);


ALTER TABLE "public"."sifat_pekerjaan" OWNER TO "postgres";

--
-- TOC entry 2012 (class 0 OID 24820)
-- Dependencies: 170
-- Data for Name: activity; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 2013 (class 0 OID 24831)
-- Dependencies: 171
-- Data for Name: akun; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO "akun" ("id_akun", "id_jabatan", "id_departemen", "nip", "nama", "alamat", "jenis_kelamin", "agama", "telepon", "hp", "email", "akun_password") VALUES (0, NULL, NULL, 'niptesting', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'nippassword');


--
-- TOC entry 2014 (class 0 OID 24839)
-- Dependencies: 172
-- Data for Name: departemen; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 2015 (class 0 OID 24845)
-- Dependencies: 173
-- Data for Name: detil_pekerjaan; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 2016 (class 0 OID 24853)
-- Dependencies: 174
-- Data for Name: file; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 2017 (class 0 OID 24860)
-- Dependencies: 175
-- Data for Name: jabatan; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 2018 (class 0 OID 24866)
-- Dependencies: 176
-- Data for Name: komentar; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 2019 (class 0 OID 24877)
-- Dependencies: 177
-- Data for Name: pekerjaan; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 2020 (class 0 OID 24887)
-- Dependencies: 178
-- Data for Name: sifat_pekerjaan; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 1860 (class 2606 OID 24827)
-- Name: pk_activity; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "activity"
    ADD CONSTRAINT "pk_activity" PRIMARY KEY ("id_activity");


--
-- TOC entry 1865 (class 2606 OID 24835)
-- Name: pk_akun; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "akun"
    ADD CONSTRAINT "pk_akun" PRIMARY KEY ("id_akun");


--
-- TOC entry 1870 (class 2606 OID 24843)
-- Name: pk_departemen; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "departemen"
    ADD CONSTRAINT "pk_departemen" PRIMARY KEY ("id_departemen");


--
-- TOC entry 1873 (class 2606 OID 24849)
-- Name: pk_detil_pekerjaan; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "detil_pekerjaan"
    ADD CONSTRAINT "pk_detil_pekerjaan" PRIMARY KEY ("id_detil_pekerjaan");


--
-- TOC entry 1878 (class 2606 OID 24857)
-- Name: pk_file; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "file"
    ADD CONSTRAINT "pk_file" PRIMARY KEY ("id_file");


--
-- TOC entry 1882 (class 2606 OID 24864)
-- Name: pk_jabatan; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "jabatan"
    ADD CONSTRAINT "pk_jabatan" PRIMARY KEY ("id_jabatan");


--
-- TOC entry 1885 (class 2606 OID 24873)
-- Name: pk_komentar; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "komentar"
    ADD CONSTRAINT "pk_komentar" PRIMARY KEY ("id_komentar");


--
-- TOC entry 1890 (class 2606 OID 24884)
-- Name: pk_pekerjaan; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "pekerjaan"
    ADD CONSTRAINT "pk_pekerjaan" PRIMARY KEY ("id_pekerjaan");


--
-- TOC entry 1893 (class 2606 OID 24891)
-- Name: pk_sifat_pekerjaan; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "sifat_pekerjaan"
    ADD CONSTRAINT "pk_sifat_pekerjaan" PRIMARY KEY ("id_sifat_pekerjaan");


--
-- TOC entry 1858 (class 1259 OID 24828)
-- Name: activity_pk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX "activity_pk" ON "activity" USING "btree" ("id_activity");


--
-- TOC entry 1863 (class 1259 OID 24836)
-- Name: akun_pk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX "akun_pk" ON "akun" USING "btree" ("id_akun");


--
-- TOC entry 1868 (class 1259 OID 24844)
-- Name: departemen_pk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX "departemen_pk" ON "departemen" USING "btree" ("id_departemen");


--
-- TOC entry 1871 (class 1259 OID 24850)
-- Name: detil_pekerjaan_pk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX "detil_pekerjaan_pk" ON "detil_pekerjaan" USING "btree" ("id_detil_pekerjaan");


--
-- TOC entry 1876 (class 1259 OID 24858)
-- Name: file_pk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX "file_pk" ON "file" USING "btree" ("id_file");


--
-- TOC entry 1880 (class 1259 OID 24865)
-- Name: jabatan_pk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX "jabatan_pk" ON "jabatan" USING "btree" ("id_jabatan");


--
-- TOC entry 1883 (class 1259 OID 24874)
-- Name: komentar_pk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX "komentar_pk" ON "komentar" USING "btree" ("id_komentar");


--
-- TOC entry 1888 (class 1259 OID 24885)
-- Name: pekerjaan_pk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX "pekerjaan_pk" ON "pekerjaan" USING "btree" ("id_pekerjaan");


--
-- TOC entry 1861 (class 1259 OID 24830)
-- Name: relationship_10_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "relationship_10_fk" ON "activity" USING "btree" ("id_detil_pekerjaan");


--
-- TOC entry 1866 (class 1259 OID 24837)
-- Name: relationship_1_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "relationship_1_fk" ON "akun" USING "btree" ("id_jabatan");


--
-- TOC entry 1867 (class 1259 OID 24838)
-- Name: relationship_2_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "relationship_2_fk" ON "akun" USING "btree" ("id_departemen");


--
-- TOC entry 1874 (class 1259 OID 24851)
-- Name: relationship_3_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "relationship_3_fk" ON "detil_pekerjaan" USING "btree" ("id_akun");


--
-- TOC entry 1875 (class 1259 OID 24852)
-- Name: relationship_4_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "relationship_4_fk" ON "detil_pekerjaan" USING "btree" ("id_pekerjaan");


--
-- TOC entry 1891 (class 1259 OID 24886)
-- Name: relationship_5_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "relationship_5_fk" ON "pekerjaan" USING "btree" ("id_sifat_pekerjaan");


--
-- TOC entry 1886 (class 1259 OID 24875)
-- Name: relationship_6_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "relationship_6_fk" ON "komentar" USING "btree" ("id_akun");


--
-- TOC entry 1887 (class 1259 OID 24876)
-- Name: relationship_7_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "relationship_7_fk" ON "komentar" USING "btree" ("id_pekerjaan");


--
-- TOC entry 1879 (class 1259 OID 24859)
-- Name: relationship_8_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "relationship_8_fk" ON "file" USING "btree" ("id_pekerjaan");


--
-- TOC entry 1862 (class 1259 OID 24829)
-- Name: relationship_9_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "relationship_9_fk" ON "activity" USING "btree" ("id_akun");


--
-- TOC entry 1894 (class 1259 OID 24892)
-- Name: sifat_pekerjaan_pk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX "sifat_pekerjaan_pk" ON "sifat_pekerjaan" USING "btree" ("id_sifat_pekerjaan");


--
-- TOC entry 1896 (class 2606 OID 24898)
-- Name: fk_activity_relations_akun; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "activity"
    ADD CONSTRAINT "fk_activity_relations_akun" FOREIGN KEY ("id_akun") REFERENCES "akun"("id_akun") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 1895 (class 2606 OID 24893)
-- Name: fk_activity_relations_detil_pe; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "activity"
    ADD CONSTRAINT "fk_activity_relations_detil_pe" FOREIGN KEY ("id_detil_pekerjaan") REFERENCES "detil_pekerjaan"("id_detil_pekerjaan") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 1898 (class 2606 OID 24908)
-- Name: fk_akun_relations_departem; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "akun"
    ADD CONSTRAINT "fk_akun_relations_departem" FOREIGN KEY ("id_departemen") REFERENCES "departemen"("id_departemen") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 1897 (class 2606 OID 24903)
-- Name: fk_akun_relations_jabatan; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "akun"
    ADD CONSTRAINT "fk_akun_relations_jabatan" FOREIGN KEY ("id_jabatan") REFERENCES "jabatan"("id_jabatan") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 1899 (class 2606 OID 24913)
-- Name: fk_detil_pe_relations_akun; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "detil_pekerjaan"
    ADD CONSTRAINT "fk_detil_pe_relations_akun" FOREIGN KEY ("id_akun") REFERENCES "akun"("id_akun") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 1900 (class 2606 OID 24918)
-- Name: fk_detil_pe_relations_pekerjaa; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "detil_pekerjaan"
    ADD CONSTRAINT "fk_detil_pe_relations_pekerjaa" FOREIGN KEY ("id_pekerjaan") REFERENCES "pekerjaan"("id_pekerjaan") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 1901 (class 2606 OID 24923)
-- Name: fk_file_relations_pekerjaa; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "file"
    ADD CONSTRAINT "fk_file_relations_pekerjaa" FOREIGN KEY ("id_pekerjaan") REFERENCES "pekerjaan"("id_pekerjaan") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 1902 (class 2606 OID 24928)
-- Name: fk_komentar_relations_akun; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "komentar"
    ADD CONSTRAINT "fk_komentar_relations_akun" FOREIGN KEY ("id_akun") REFERENCES "akun"("id_akun") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 1903 (class 2606 OID 24933)
-- Name: fk_komentar_relations_pekerjaa; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "komentar"
    ADD CONSTRAINT "fk_komentar_relations_pekerjaa" FOREIGN KEY ("id_pekerjaan") REFERENCES "pekerjaan"("id_pekerjaan") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 1904 (class 2606 OID 24938)
-- Name: fk_pekerjaa_relations_sifat_pe; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "pekerjaan"
    ADD CONSTRAINT "fk_pekerjaa_relations_sifat_pe" FOREIGN KEY ("id_sifat_pekerjaan") REFERENCES "sifat_pekerjaan"("id_sifat_pekerjaan") ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2027 (class 0 OID 0)
-- Dependencies: 5
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA "public" FROM PUBLIC;
REVOKE ALL ON SCHEMA "public" FROM "postgres";
GRANT ALL ON SCHEMA "public" TO "postgres";
GRANT ALL ON SCHEMA "public" TO PUBLIC;


-- Completed on 2014-03-21 00:10:30

--
-- PostgreSQL database dump complete
--

