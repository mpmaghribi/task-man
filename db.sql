--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

--
-- Name: kategori_pekerjaan; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE kategori_pekerjaan AS ENUM (
    'rutin',
    'project'
);


ALTER TYPE kategori_pekerjaan OWNER TO postgres;

--
-- Name: function_login(character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION function_login(f_username character varying, f_pwd character varying) RETURNS record
    LANGUAGE plpgsql
    AS $$declare

hasil RECORD;
BEGIN
	IF (SELECT 1 FROM akun WHERE nip = f_username AND akun_password = f_pwd) THEN
		SELECT 1, nip, nama, email into hasil FROM akun WHERE nip = f_username AND akun_password = f_pwd;
	ELSE 
		SELECT -1 , nip, nama, email into hasil FROM akun WHERE nip = f_username AND akun_password = f_pwd;
	END IF;
	return hasil;
END;$$;


ALTER FUNCTION public.function_login(f_username character varying, f_pwd character varying) OWNER TO postgres;

--
-- Name: function_register(integer, integer, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION function_register(f_jabatan integer, f_departemen integer, f_nip character varying, f_nama character varying, f_alamat character varying, f_gender character varying, f_agama character varying, f_homephone character varying, f_mobilephone character varying, f_email character varying, f_password character varying) RETURNS record
    LANGUAGE plpgsql
    AS $$declare
hasil RECORD;
BEGIN

	IF (SELECT 1 FROM akun WHERE nip=f_nip OR akun_password=f_email) THEN
		SELECT 1 into hasil;
	ELSE 
		SELECT 0 into hasil;
		INSERT INTO akun (id_jabatan, id_departemen, nip, nama, alamat, jenis_kelamin, agama, telepon, hp, email, akun_password) VALUES (f_jabatan, f_departemen, f_nip, f_nama, f_alamat, f_gender,f_agama, f_homephone, f_mobilephone, f_email, f_password);
	END IF;
	return hasil;
END;$$;


ALTER FUNCTION public.function_register(f_jabatan integer, f_departemen integer, f_nip character varying, f_nama character varying, f_alamat character varying, f_gender character varying, f_agama character varying, f_homephone character varying, f_mobilephone character varying, f_email character varying, f_password character varying) OWNER TO postgres;

--
-- Name: function_tambah_detil_pekerjaan(integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION function_tambah_detil_pekerjaan(f_id_pekerjaan_baru integer, f_id_akun integer) RETURNS record
    LANGUAGE plpgsql
    AS $$DECLARE
hasil record;
Begin
select -1 into hasil;
insert into detil_pekerjaan (id_pekerjaan, id_akun, skor, progress,status)
values (f_id_pekerjaan_baru,f_id_akun,0,0,'Not Approved');
select cast(currval('tbl_pekerjaan_id') as integer) into hasil;
return hasil;
End;$$;


ALTER FUNCTION public.function_tambah_detil_pekerjaan(f_id_pekerjaan_baru integer, f_id_akun integer) OWNER TO postgres;

--
-- Name: function_tambah_pkj(integer, integer, character varying, character varying, date, date, character varying, character varying, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION function_tambah_pkj(f_id_sifat_pkj integer, f_parent_pkj integer, f_nama_pkj character varying, f_deskripsi_pkj character varying, f_tgl_mulai date, f_tgl_selesai date, f_status_pkj character varying, f_asal_pkj character varying, f_prioritas_pkj integer) RETURNS record
    LANGUAGE plpgsql
    AS $$DECLARE
hasil record;
Begin
select -1 into hasil;
insert into pekerjaan (id_sifat_pekerjaan, parent_pekerjaan, nama_pekerjaan, deskripsi_pekerjaan, tgl_mulai, tgl_selesai, asal_pekerjaan, level_prioritas, flag_usulan)
values (f_id_sifat_pkj, f_parent_pkj, f_nama_pkj, f_deskripsi_pkj, f_tgl_mulai, f_tgl_selesai, f_asal_pkj,f_prioritas_pkj, f_status_pkj);
select cast(currval('tbl_pekerjaan_id') as integer) into hasil;
return hasil;
End;$$;


ALTER FUNCTION public.function_tambah_pkj(f_id_sifat_pkj integer, f_parent_pkj integer, f_nama_pkj character varying, f_deskripsi_pkj character varying, f_tgl_mulai date, f_tgl_selesai date, f_status_pkj character varying, f_asal_pkj character varying, f_prioritas_pkj integer) OWNER TO postgres;

--
-- Name: tes(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION tes(angka integer) RETURNS integer
    LANGUAGE plpgsql
    AS $$begin
	return angka +100;
end;$$;


ALTER FUNCTION public.tes(angka integer) OWNER TO postgres;

--
-- Name: tbl_activity_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tbl_activity_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tbl_activity_id OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: activity; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE activity (
    id_activity integer DEFAULT nextval('tbl_activity_id'::regclass) NOT NULL,
    id_akun integer,
    id_detil_pekerjaan integer,
    nama_activity character varying(50),
    deskripsi_activity text,
    tanggal_activity timestamp with time zone
);


ALTER TABLE activity OWNER TO postgres;

--
-- Name: aktivitas_pekerjaan_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE aktivitas_pekerjaan_seq
    START WITH 16
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE aktivitas_pekerjaan_seq OWNER TO postgres;

--
-- Name: aktivitas_pekerjaan; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE aktivitas_pekerjaan (
    id_aktivitas integer DEFAULT nextval('aktivitas_pekerjaan_seq'::regclass) NOT NULL,
    id_pekerjaan integer,
    id_akun integer,
    tanggal_transaksi timestamp with time zone,
    waktu_mulai timestamp with time zone,
    waktu_selesai timestamp with time zone,
    kuantitas_output double precision,
    kualitas_mutu double precision,
    biaya double precision,
    angka_kredit double precision,
    keterangan character varying(1000),
    status_validasi integer DEFAULT 0
);


ALTER TABLE aktivitas_pekerjaan OWNER TO postgres;

--
-- Name: tbl_detil_pekerjaan_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tbl_detil_pekerjaan_id
    START WITH 25
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE tbl_detil_pekerjaan_id OWNER TO postgres;

--
-- Name: detil_pekerjaan; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE detil_pekerjaan (
    id_detil_pekerjaan integer DEFAULT nextval('tbl_detil_pekerjaan_id'::regclass) NOT NULL,
    id_pekerjaan integer,
    id_akun integer,
    tgl_read date,
    tglasli_mulai date,
    tglasli_selesai date,
    skor integer DEFAULT 0 NOT NULL,
    progress integer DEFAULT 0 NOT NULL,
    status character varying(100),
    sasaran_angka_kredit double precision DEFAULT 0,
    sasaran_kuantitas_output double precision DEFAULT 0,
    sasaran_kualitas_mutu double precision DEFAULT 0,
    sasaran_waktu double precision DEFAULT 0,
    sasaran_biaya double precision DEFAULT 0,
    realisasi_angka_kredit double precision DEFAULT 0,
    realisasi_kuantitas_output double precision DEFAULT 0,
    realisasi_kualitas_mutu double precision DEFAULT 0,
    realisasi_waktu double precision DEFAULT 0,
    realisasi_biaya double precision DEFAULT 0,
    pakai_biaya integer DEFAULT 1,
    satuan_kuantitas character varying(200) DEFAULT 'item'::character varying,
    satuan_waktu character varying(200) DEFAULT 'bulan'::character varying
);


ALTER TABLE detil_pekerjaan OWNER TO postgres;

--
-- Name: detil_progress; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE detil_progress (
    id_detil_progress integer NOT NULL,
    id_detil_pekerjaan integer,
    deksripsi text,
    progress integer,
    total_progress integer,
    waktu timestamp with time zone
);


ALTER TABLE detil_progress OWNER TO postgres;

--
-- Name: COLUMN detil_progress.id_detil_pekerjaan; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN detil_progress.id_detil_pekerjaan IS 'foreign key dari detil_pekerjaan';


--
-- Name: COLUMN detil_progress.deksripsi; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN detil_progress.deksripsi IS 'deksripsi, keterangan progress yang dilakukan';


--
-- Name: COLUMN detil_progress.progress; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN detil_progress.progress IS 'nilai progress saat ini, bukan akumulasi';


--
-- Name: COLUMN detil_progress.total_progress; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN detil_progress.total_progress IS 'akumulasi total progress sampai saat ini';


--
-- Name: COLUMN detil_progress.waktu; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN detil_progress.waktu IS 'waktu progress dilakukan';


--
-- Name: detil_progress_id_detil_progress_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE detil_progress_id_detil_progress_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE detil_progress_id_detil_progress_seq OWNER TO postgres;

--
-- Name: detil_progress_id_detil_progress_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE detil_progress_id_detil_progress_seq OWNED BY detil_progress.id_detil_progress;


--
-- Name: tbl_file_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tbl_file_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tbl_file_id OWNER TO postgres;

--
-- Name: file; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE file (
    id_file integer DEFAULT nextval('tbl_file_id'::regclass) NOT NULL,
    id_pekerjaan integer,
    nama_file character varying(100),
    waktu timestamp with time zone,
    id_progress integer
);


ALTER TABLE file OWNER TO postgres;

--
-- Name: tbl_komentar_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tbl_komentar_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tbl_komentar_id OWNER TO postgres;

--
-- Name: komentar; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE komentar (
    id_komentar integer DEFAULT nextval('tbl_komentar_id'::regclass) NOT NULL,
    id_akun integer,
    id_pekerjaan integer,
    isi_komentar text,
    tgl_komentar timestamp with time zone,
    history_komentar text
);


ALTER TABLE komentar OWNER TO postgres;

--
-- Name: nilai_pekerjaan; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE nilai_pekerjaan (
    id_nilai integer NOT NULL,
    ak integer,
    kuatitas_output integer,
    kualitas_mutu integer,
    waktu integer,
    biaya integer,
    penghitungan double precision,
    nilai_skp double precision,
    satuan_waktu character varying(50),
    id_detil_pekerjaan integer,
    id_tipe_nilai integer
);


ALTER TABLE nilai_pekerjaan OWNER TO postgres;

--
-- Name: nilai_pekerjaan_id_nilai_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE nilai_pekerjaan_id_nilai_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE nilai_pekerjaan_id_nilai_seq OWNER TO postgres;

--
-- Name: nilai_pekerjaan_id_nilai_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE nilai_pekerjaan_id_nilai_seq OWNED BY nilai_pekerjaan.id_nilai;


--
-- Name: tbl_pekerjaan_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tbl_pekerjaan_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE tbl_pekerjaan_id OWNER TO postgres;

--
-- Name: pekerjaan; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE pekerjaan (
    id_pekerjaan integer DEFAULT nextval('tbl_pekerjaan_id'::regclass) NOT NULL,
    id_sifat_pekerjaan integer,
    parent_pekerjaan integer,
    nama_pekerjaan character varying(2000),
    deskripsi_pekerjaan text,
    tgl_mulai timestamp with time zone,
    tgl_selesai timestamp with time zone,
    asal_pekerjaan character varying(50),
    level_prioritas integer,
    flag_usulan character varying,
    id_pengaduan integer,
    kategori character varying(1000),
    id_penanggung_jawab integer,
    id_pengusul integer,
    status_pekerjaan integer,
    periode integer,
    level_manfaat integer
);


ALTER TABLE pekerjaan OWNER TO postgres;

--
-- Name: COLUMN pekerjaan.flag_usulan; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN pekerjaan.flag_usulan IS '1=>usulan
2=>approved
3=>pekerjaan batal
5=>draft
6=>draft batal';


--
-- Name: COLUMN pekerjaan.level_manfaat; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN pekerjaan.level_manfaat IS '1=>level unit kerja
2=>level organisasi
3=>level negara';


--
-- Name: pengaduan; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE pengaduan (
    id_pengaduan integer NOT NULL,
    topik_pengaduan character varying(250),
    isi_pengaduan character varying(1024),
    tanggal_pengaduan timestamp with time zone,
    rekomendasi_urgensitas integer,
    respon integer,
    alasan_respon character varying(1024)
);


ALTER TABLE pengaduan OWNER TO postgres;

--
-- Name: pengaduan_id_pengaduan_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE pengaduan_id_pengaduan_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE pengaduan_id_pengaduan_seq OWNER TO postgres;

--
-- Name: pengaduan_id_pengaduan_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE pengaduan_id_pengaduan_seq OWNED BY pengaduan.id_pengaduan;


--
-- Name: primary_pemberi_pekerjaan; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE primary_pemberi_pekerjaan
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE primary_pemberi_pekerjaan OWNER TO postgres;

--
-- Name: tbl_sifat_pkj_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tbl_sifat_pkj_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tbl_sifat_pkj_id OWNER TO postgres;

--
-- Name: sifat_pekerjaan; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sifat_pekerjaan (
    id_sifat_pekerjaan integer DEFAULT nextval('tbl_sifat_pkj_id'::regclass) NOT NULL,
    nama_sifat_pekerjaan character varying(50)
);


ALTER TABLE sifat_pekerjaan OWNER TO postgres;

--
-- Name: status; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE status (
    status_id integer NOT NULL,
    status_nama character varying(300)
);


ALTER TABLE status OWNER TO postgres;

--
-- Name: status_pekerjaan; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE status_pekerjaan (
    id_status_pekerjaan integer NOT NULL,
    nama_status_pekerjaan character varying(200)
);


ALTER TABLE status_pekerjaan OWNER TO postgres;

--
-- Name: tbl_akun_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tbl_akun_id
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tbl_akun_id OWNER TO postgres;

--
-- Name: tbl_departemen_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tbl_departemen_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tbl_departemen_id OWNER TO postgres;

--
-- Name: tbl_jabatan_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tbl_jabatan_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tbl_jabatan_id OWNER TO postgres;

--
-- Name: tipe_nilai; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tipe_nilai (
    id_tipe_nilai integer NOT NULL,
    nama_tipe character varying(100),
    keterangan_tipe character varying(500)
);


ALTER TABLE tipe_nilai OWNER TO postgres;

--
-- Name: tipe_nilai_id_tipe_nilai_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tipe_nilai_id_tipe_nilai_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tipe_nilai_id_tipe_nilai_seq OWNER TO postgres;

--
-- Name: tipe_nilai_id_tipe_nilai_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tipe_nilai_id_tipe_nilai_seq OWNED BY tipe_nilai.id_tipe_nilai;


--
-- Name: id_detil_progress; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY detil_progress ALTER COLUMN id_detil_progress SET DEFAULT nextval('detil_progress_id_detil_progress_seq'::regclass);


--
-- Name: id_nilai; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY nilai_pekerjaan ALTER COLUMN id_nilai SET DEFAULT nextval('nilai_pekerjaan_id_nilai_seq'::regclass);


--
-- Name: id_pengaduan; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY pengaduan ALTER COLUMN id_pengaduan SET DEFAULT nextval('pengaduan_id_pengaduan_seq'::regclass);


--
-- Name: id_tipe_nilai; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tipe_nilai ALTER COLUMN id_tipe_nilai SET DEFAULT nextval('tipe_nilai_id_tipe_nilai_seq'::regclass);


--
-- Data for Name: activity; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY activity (id_activity, id_akun, id_detil_pekerjaan, nama_activity, deskripsi_activity, tanggal_activity) FROM stdin;
3	2	0	Login	baru saja login	2014-04-22 18:16:06.558+07
4	2	0	Login	baru saja login	2014-04-24 23:32:45.677+07
5	2	0	Login	baru saja login	2014-04-25 13:07:45.259+07
6	2	0	Login	baru saja login	2014-04-25 17:23:51.303+07
7	2	0	Validasi Pekerjaan Staff	Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-04-25 21:17:53.974+07
8	2	0	Validasi Pekerjaan Staff	Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-04-25 21:18:35.195+07
9	2	0	Validasi Pekerjaan Staff	Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-04-25 21:19:01.984+07
10	2	0	Validasi Pekerjaan Staff	Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-04-25 21:19:13.913+07
11	2	0	Validasi Pekerjaan Staff	Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-04-25 21:19:15.182+07
12	2	0	Login	baru saja login	2014-04-26 12:41:30.053+07
13	2	0	Validasi Pekerjaan Staff	Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-04-26 12:42:39.554+07
14	2	0	Login	baru saja login	2014-04-28 18:42:51.192+07
15	3	0	Login	baru saja login	2014-04-28 18:50:25.151+07
16	3	0	Login	baru saja login	2014-04-28 19:02:55.774+07
17	2	0	Login	baru saja login	2014-04-28 19:04:59.073+07
18	3	0	Login	baru saja login	2014-04-28 17:21:04.166+07
19	3	0	Logout	baru saja logout	2014-04-28 17:21:34.581+07
20	2	0	Login	baru saja login	2014-04-28 17:21:41.98+07
21	2	0	Logout	baru saja logout	2014-04-28 17:22:35.838+07
22	2	0	Login	baru saja login	2014-04-28 17:22:47.718+07
23	2	0	Logout	baru saja logout	2014-04-28 17:23:46.436+07
24	3	0	Login	baru saja login	2014-04-28 17:23:54.849+07
25	3	0	Logout	baru saja logout	2014-04-28 19:22:39.509+07
26	2	0	Login	baru saja login	2014-04-28 19:23:07.365+07
27	2	0	Logout	baru saja logout	2014-04-28 20:12:12.025+07
28	3	0	Login	baru saja login	2014-04-28 20:12:23.05+07
29	2	0	Login	baru saja login	2014-04-28 23:30:01.207+07
30	2	0	Logout	baru saja logout	2014-04-29 00:11:59.71+07
31	3	0	Login	baru saja login	2014-04-29 00:12:06.746+07
32	3	0	Logout	baru saja logout	2014-04-29 00:19:44.732+07
33	2	0	Login	baru saja login	2014-04-29 00:19:49.622+07
34	2	0	Logout	baru saja logout	2014-04-29 02:11:48.303+07
35	3	0	Login	baru saja login	2014-04-29 02:11:56.201+07
36	3	0	Logout	baru saja logout	2014-04-29 02:12:28.806+07
37	2	0	Login	baru saja login	2014-04-29 08:51:01.568+07
38	2	0	Validasi Pekerjaan Staff	Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-04-29 09:00:20.089+07
39	2	0	Validasi Pekerjaan Staff	Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-04-29 09:00:22.782+07
40	2	0	Validasi Pekerjaan Staff	Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-04-29 09:02:03.114+07
41	2	0	Validasi Pekerjaan Staff	Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-04-29 09:02:04.588+07
42	2	0	Validasi Pekerjaan Staff	Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-04-29 09:02:59.778+07
43	2	0	Validasi Pekerjaan Staff	Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-04-29 09:03:00.577+07
44	2	0	Validasi Pekerjaan Staff	Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-04-29 09:03:01.041+07
45	2	0	Validasi Pekerjaan Staff	Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-04-29 09:14:48.81+07
46	2	0	Validasi Pekerjaan Staff	Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-04-29 09:14:51.06+07
47	2	0	Validasi Pekerjaan Staff	Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-04-29 09:14:52.536+07
48	2	0	Validasi Pekerjaan Staff	Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-04-29 09:14:54.063+07
49	2	0	Validasi Pekerjaan Staff	Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-04-29 09:14:59.645+07
50	2	0	Validasi Pekerjaan Staff	Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-04-29 09:17:34.403+07
51	2	0	Login	baru saja login	2014-04-29 15:56:55.122+07
52	2	0	Login	baru saja login	2014-04-29 23:35:33.584+07
53	2	0	Login	baru saja login	2014-04-30 22:38:01.243+07
54	2	0	Validasi Pekerjaan Staff	Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-04-30 23:35:10.145+07
55	2	0	Validasi Pekerjaan Staff	Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-04-30 23:35:10.846+07
56	2	0	Validasi Pekerjaan Staff	Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-04-30 23:35:11.698+07
57	2	0	Validasi Pekerjaan Staff	Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-04-30 23:35:12.062+07
58	2	0	Login	baru saja login	2014-05-01 13:20:19.197+07
59	2	0	Login	baru saja login	2014-05-01 15:51:55.793+07
60	2	0	Login	baru saja login	2014-05-01 21:36:16.798+07
61	3	0	Login	baru saja login	2014-05-01 23:04:31.554+07
62	2	0	Validasi Pekerjaan Staff	Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-05-01 23:16:17.088+07
63	2	0	Validasi Pekerjaan Staff	Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-05-01 23:16:18.613+07
64	2	0	Validasi Pekerjaan Staff	Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-05-01 23:16:19.177+07
65	2	0	Validasi Pekerjaan Staff	Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-05-01 23:16:19.772+07
66	2	0	Validasi Pekerjaan Staff	Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-05-01 23:16:20.41+07
67	2	0	Login	baru saja login	2014-05-02 14:04:28.022+07
68	2	0	Komentar	baru saja memberikan komentar	2014-05-02 14:06:14.528+07
69	2	0	Komentar	baru saja memberikan komentar	2014-05-02 14:07:36.834+07
70	2	0	Komentar	baru saja memberikan komentar	2014-05-02 14:09:44.766+07
71	2	0	Komentar	baru saja memberikan komentar	2014-05-02 14:09:56.009+07
72	2	0	Komentar	baru saja memberikan komentar	2014-05-02 14:10:58.258+07
73	2	0	Komentar	baru saja memberikan komentar	2014-05-02 14:15:35.765+07
74	2	0	Komentar	baru saja memberikan komentar	2014-05-02 14:15:52.309+07
76	2	0	Komentar	baru saja memberikan komentar	2014-05-02 14:19:16.979+07
75	2	0	Komentar	baru saja memberikan komentar	2014-05-02 14:16:18.928+07
77	2	0	Komentar	baru saja memberikan komentar	2014-05-02 14:22:16.077+07
78	3	0	Login	baru saja login	2014-05-02 17:00:58.353+07
79	2	0	Login	baru saja login	2014-05-03 09:55:41.521+07
80	2	0	Login	baru saja login	2014-05-03 12:52:21.003+07
81	2	0	Login	baru saja login	2014-05-03 13:59:49.214+07
82	1	0	Logout	baru saja logout	2014-05-05 13:45:19.615+07
83	1	0	Logout	baru saja logout	2014-05-05 13:46:55.865+07
84	1	0	Logout	baru saja logout	2014-05-05 13:48:49.55+07
85	1	0	Logout	baru saja logout	2014-05-05 16:34:03.834+07
86	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 19:57:29.355+07
87	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-07 19:57:57.636+07
88	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-05-07 19:58:06.153+07
89	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-07 19:58:10.947+07
90	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-07 19:58:15.494+07
91	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-07 19:58:21.624+07
92	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-07 19:58:31.97+07
93	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 19:58:43.363+07
94	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-07 20:09:09.898+07
95	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-05-07 20:09:18.244+07
96	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 20:09:20.67+07
97	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-07 20:09:34.578+07
98	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-05-07 20:09:39.169+07
99	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 20:09:41.698+07
100	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 20:30:24.992+07
101	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 20:30:35.47+07
102	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 20:31:11.434+07
103	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 20:35:38.411+07
104	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 20:46:14.408+07
105	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 20:51:33.459+07
106	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 20:51:39.547+07
107	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 20:52:51.539+07
108	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 20:53:30.268+07
109	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 20:53:43.647+07
110	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 20:54:53.837+07
111	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 20:57:08.216+07
112	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 20:57:49.008+07
113	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 20:59:26.286+07
114	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 20:59:56.12+07
115	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 21:00:38.329+07
116	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 21:07:36.266+07
117	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 21:08:01.677+07
118	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 21:11:46.2+07
119	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 21:12:56.974+07
120	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 21:13:26.788+07
121	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 21:13:56.117+07
122	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 21:14:36.637+07
123	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 21:16:51.359+07
124	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 21:17:31.716+07
125	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 21:18:33.223+07
126	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 21:19:09.208+07
127	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 21:20:56.807+07
128	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 21:21:23.317+07
129	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 21:22:09.489+07
130	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 21:24:19.561+07
131	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 21:25:02.453+07
132	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 21:25:56.337+07
133	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 21:27:04.864+07
134	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 21:27:56.617+07
135	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 22:46:30.006+07
136	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 22:51:57.509+07
137	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 22:52:12.475+07
138	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 22:53:56.293+07
139	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-07 22:54:06.154+07
140	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 22:54:23.617+07
141	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 22:55:19.807+07
142	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-07 22:56:17.523+07
143	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-07 22:56:25.465+07
144	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-08 16:11:59.874+07
145	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-08 16:12:12.788+07
153	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-08 16:42:17.755+07
146	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 16:12:17.006+07
147	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-08 16:13:25.345+07
148	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 16:34:22.549+07
149	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 16:34:33.037+07
150	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 16:34:52.525+07
151	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 16:35:07.553+07
152	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 16:38:25.187+07
155	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-08 16:43:25.531+07
156	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-08 16:43:40.206+07
157	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 16:46:24.143+07
158	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 16:48:07.591+07
163	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 16:57:52.824+07
164	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 16:58:04.731+07
165	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 16:58:36.171+07
166	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 16:59:22.582+07
167	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 17:00:04.574+07
169	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 17:04:21.68+07
171	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 17:05:33.346+07
172	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 17:06:22.902+07
154	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-08 16:42:32.376+07
161	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 16:52:07.654+07
168	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 17:00:18.018+07
159	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 16:51:04.355+07
160	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 16:51:24.579+07
162	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 16:52:48.296+07
170	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 17:04:48.225+07
173	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-08 20:19:04.629+07
174	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 20:21:27.745+07
175	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-08 20:44:49.908+07
176	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 20:54:56.376+07
177	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 20:55:17.606+07
178	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-08 20:55:38.814+07
179	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 20:55:52.164+07
180	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-08 20:56:51.801+07
181	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 20:56:59.582+07
182	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 20:59:15.14+07
183	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 20:59:46.817+07
184	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 21:00:14.79+07
185	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 21:02:10.246+07
186	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 21:02:17.58+07
187	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 21:02:27.61+07
188	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 21:04:45.809+07
189	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 21:04:53.997+07
190	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 21:05:23.26+07
191	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 21:05:26.178+07
192	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-08 21:05:35.877+07
193	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 21:06:59.648+07
194	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-08 21:10:04.378+07
195	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-08 21:11:14.412+07
196	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 21:13:41.266+07
197	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-08 21:13:48.138+07
198	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-08 21:24:53.82+07
199	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-08 21:24:57.657+07
200	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 21:25:05.72+07
201	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 21:25:19.363+07
202	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 21:28:16.345+07
203	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 21:30:25.339+07
204	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 21:31:57.148+07
205	1	0	Aktivitas Logout	Dr. Bendrong baru saja sgn out dari SI Task Management.	2014-05-08 21:34:33.747+07
206	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-08 21:35:29.749+07
207	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-08 21:35:55.423+07
208	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 21:36:02.671+07
209	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 21:36:26.984+07
210	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 21:45:02.003+07
211	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-08 21:45:06.398+07
212	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-08 21:45:16.228+07
213	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-08 21:45:35.129+07
214	1	0	Aktivitas Logout	Dr. Bendrong baru saja sgn out dari SI Task Management.	2014-05-08 21:52:33.883+07
215	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-08 21:53:07.839+07
216	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-08 21:53:08.028+07
217	3	0	Aktivitas Profil	Budiono sedang melihat profil miliknya sendiri..	2014-05-08 21:53:21.671+07
218	3	0	Aktivitas Pekerjaan	Budiono sedang berada di halaman pekerjaan.	2014-05-08 22:02:30.991+07
219	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-09 15:16:32.455+07
220	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-09 15:18:40.515+07
221	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-09 15:20:31.703+07
222	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja mengusulkan pekerjaan.	2014-05-09 15:21:01.782+07
223	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-09 15:21:02.052+07
224	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 15:21:11.632+07
225	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-05-09 15:21:15.033+07
226	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-09 15:21:21.071+07
227	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 15:21:36.216+07
228	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 15:37:49.735+07
229	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 15:39:24.445+07
230	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 15:41:57.677+07
231	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 15:42:37.465+07
232	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : mohon menghubungi pak xxx untuk data tambahan	2014-05-09 15:42:37.535+07
233	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 15:48:09.611+07
234	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 15:56:00.844+07
235	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 15:56:29.675+07
236	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 15:57:03.146+07
237	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 16:00:47.269+07
238	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 16:05:50.904+07
239	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 16:06:14.501+07
240	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 16:06:31.507+07
241	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 16:06:43.819+07
242	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 16:07:23.693+07
243	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-09 16:09:18.994+07
244	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-09 16:09:37.37+07
245	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 16:09:41.556+07
246	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 16:10:27.054+07
247	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 16:11:18.124+07
248	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 16:11:40.55+07
249	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 16:14:22.168+07
250	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 16:14:52.599+07
251	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 16:16:37.056+07
252	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 16:16:51.754+07
253	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 16:18:07.952+07
254	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 16:20:45.757+07
255	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 16:45:51.896+07
256	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 16:47:53.535+07
257	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 16:48:30.568+07
258	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-09 17:00:19.315+07
259	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-09 17:00:44.322+07
260	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-09 17:01:31.362+07
261	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-09 17:02:04.19+07
262	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-09 17:02:44.163+07
263	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-09 17:03:00.837+07
264	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-09 17:03:21.017+07
265	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-09 17:03:29.102+07
266	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 17:03:46.688+07
267	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-09 17:05:39.131+07
268	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 17:05:43.239+07
269	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 17:06:05.772+07
270	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 17:06:28.646+07
271	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 17:09:09.539+07
272	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 17:09:47.611+07
273	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 17:12:56.066+07
274	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 17:13:18.147+07
275	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 17:13:53.936+07
276	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 17:17:51.969+07
277	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 17:18:43.141+07
278	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 17:20:00.131+07
279	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 17:20:19.545+07
280	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 17:50:18.485+07
281	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 17:50:39.314+07
282	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 17:51:22.061+07
283	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 17:52:46.191+07
284	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 17:53:08.988+07
285	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 17:53:36.119+07
286	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 17:53:58.904+07
287	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-09 17:54:42.999+07
288	3	0	Aktivitas Pekerjaan	Budiono sedang berada di halaman pekerjaan.	2014-05-09 17:54:48.441+07
289	3	0	Aktivitas Logout	Budiono baru saja sgn out dari SI Task Management.	2014-05-09 17:55:23.645+07
290	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-09 17:58:53.288+07
291	3	0	Aktivitas Pekerjaan	Budiono sedang berada di halaman pekerjaan.	2014-05-09 17:58:57.46+07
292	3	0	Aktivitas Pekerjaan	Budiono baru saja mengusulkan pekerjaan.	2014-05-09 18:01:44.984+07
293	3	0	Aktivitas Pekerjaan	Budiono sedang berada di halaman pekerjaan.	2014-05-09 18:01:45.218+07
294	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 18:02:03.313+07
295	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-09 18:02:11.949+07
296	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-09 18:03:05.75+07
297	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 18:03:15.267+07
298	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 18:07:10.205+07
299	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-09 18:07:18.301+07
302	3	0	Aktivitas Pekerjaan	Budiono sedang berada di halaman pekerjaan.	2014-05-09 18:07:46.919+07
306	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 18:09:35.181+07
300	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 18:07:28.602+07
303	3	0	Aktivitas Pekerjaan	Budiono sedang berada di halaman pekerjaan.	2014-05-09 18:08:00.265+07
308	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 18:12:02.4+07
301	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-09 18:07:35.813+07
304	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 18:08:15.387+07
305	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-09 18:08:18.838+07
307	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 18:10:55.66+07
310	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 18:14:12.952+07
309	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 18:13:11.286+07
311	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 18:15:55.617+07
312	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-09 19:08:06.958+07
313	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-09 19:08:17.727+07
314	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 19:08:23.29+07
315	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-09 19:08:28.707+07
316	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 19:08:32.593+07
317	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-05-09 19:08:41.466+07
318	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-09 19:08:44.414+07
319	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-09 19:08:47.531+07
320	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-09 19:08:52.174+07
321	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-09 19:08:57.431+07
322	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-09 19:09:06.112+07
323	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-09 19:09:11.256+07
324	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-09 19:10:11.732+07
325	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-10 09:56:22.85+07
326	3	0	Aktivitas Pekerjaan	Budiono sedang berada di halaman pekerjaan.	2014-05-10 09:56:26.92+07
327	3	0	Aktivitas Logout	Budiono baru saja sgn out dari SI Task Management.	2014-05-10 09:56:47.624+07
328	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-10 09:56:54.846+07
329	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-10 09:56:57.739+07
330	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-10 09:57:01.306+07
331	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-10 09:57:06.693+07
332	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-10 09:58:13.692+07
333	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-10 10:03:10.578+07
334	3	0	Aktivitas Logout	Budiono baru saja sgn out dari SI Task Management.	2014-05-10 10:03:27.67+07
335	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-10 10:05:05.002+07
336	3	0	Aktivitas Pekerjaan	Budiono sedang berada di halaman pekerjaan.	2014-05-10 10:05:07.845+07
337	3	0	Aktivitas Pekerjaan	Budiono sedang berada di halaman pekerjaan.	2014-05-10 10:05:28.541+07
338	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-10 10:08:20.051+07
339	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-10 10:09:54.345+07
340	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-10 10:10:08.268+07
341	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-10 10:13:25.384+07
342	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-10 10:14:06.077+07
343	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-10 10:14:18.813+07
344	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-10 10:14:32.58+07
345	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-10 10:15:18.284+07
346	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-10 10:16:19.943+07
347	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-10 10:18:28.326+07
348	3	0	Aktivitas Pekerjaan	Budiono sedang berada di halaman pekerjaan.	2014-05-10 10:18:32.778+07
349	3	0	Aktivitas Pekerjaan	Budiono sedang berada di halaman pekerjaan.	2014-05-10 10:19:43.001+07
350	3	0	Aktivitas Pekerjaan	Budiono baru saja mengusulkan pekerjaan.	2014-05-10 10:21:45.24+07
351	3	0	Aktivitas Pekerjaan	Budiono sedang berada di halaman pekerjaan.	2014-05-10 10:21:45.56+07
352	3	0	Aktivitas Pekerjaan	Budiono sedang melihat detail tentang pekerjaannya.	2014-05-10 10:21:51.304+07
353	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-10 10:22:03.795+07
354	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-10 10:22:08.519+07
355	3	0	Aktivitas Pekerjaan	Budiono sedang melihat detail tentang pekerjaannya.	2014-05-10 10:22:19.219+07
356	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-10 10:22:43.149+07
357	3	0	Aktivitas Pekerjaan	Budiono sedang berada di halaman pekerjaan.	2014-05-10 10:26:53.984+07
358	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-10 10:27:52.306+07
359	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-10 10:28:19.485+07
360	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-10 10:30:56.969+07
361	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-10 10:31:17.496+07
362	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-10 10:31:25.552+07
363	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-10 10:31:50.034+07
364	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-10 10:32:20.337+07
365	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-10 10:32:30.464+07
366	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-10 10:33:19.824+07
367	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-10 10:33:44.218+07
368	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-10 10:35:04.648+07
369	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-10 10:36:15.749+07
370	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-10 10:38:29.266+07
371	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-10 10:38:51.167+07
372	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-10 10:39:13.721+07
373	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-10 10:39:43.549+07
374	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-10 10:40:31.288+07
377	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-10 10:43:32.644+07
375	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-10 10:41:09.407+07
380	3	0	Aktivitas Profil	Budiono sedang melihat profil miliknya sendiri..	2014-05-10 11:05:25.808+07
376	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-10 10:42:14.02+07
378	3	0	Aktivitas Pekerjaan	Budiono sedang berada di halaman pekerjaan.	2014-05-10 10:45:12.764+07
379	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-10 11:04:03.89+07
382	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-10 11:05:37.521+07
381	3	0	Aktivitas Pekerjaan	Budiono sedang berada di halaman pekerjaan.	2014-05-10 11:05:33.009+07
383	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-10 12:12:11.513856+07
384	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-10 12:12:32.117789+07
385	3	0	Aktivitas Pekerjaan	Budiono sedang berada di halaman pekerjaan.	2014-05-10 12:12:41.632497+07
386	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-10 12:12:49.380384+07
387	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-10 12:12:53.165058+07
388	3	0	Aktivitas Pekerjaan	Budiono sedang berada di halaman pekerjaan.	2014-05-10 12:12:55.497185+07
389	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-10 12:12:57.93354+07
390	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-10 12:13:01.978405+07
391	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-10 12:13:06.984031+07
392	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 09:44:07.623+07
393	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 09:44:21.508+07
394	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 09:45:31.836+07
395	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-11 09:48:59.908+07
396	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-11 09:49:06.811+07
397	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 09:49:33.476+07
398	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 09:51:11.701+07
399	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 09:51:32.996+07
400	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 09:52:01.96+07
401	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 09:54:18.493+07
402	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 09:55:11.706+07
403	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 09:55:24.128+07
404	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 09:55:36.654+07
405	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 09:55:44.787+07
406	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 09:55:52.93+07
407	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 09:56:00.63+07
408	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 09:56:07.292+07
412	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 09:59:46.764+07
414	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 10:01:07.839+07
428	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 10:30:28.615+07
444	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-11 11:57:10.284+07
458	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 12:28:26.565+07
461	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 12:33:47.528+07
468	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 12:59:02.804+07
469	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 12:59:06.419+07
471	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 13:03:31.305+07
473	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-11 13:08:05.067+07
476	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 13:08:42.075+07
480	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 13:10:12.121+07
409	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 09:57:00.931+07
410	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 09:57:57.501+07
413	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 10:00:01.51+07
418	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-11 10:04:16.335+07
427	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 10:29:47.309+07
441	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 11:00:11.887+07
452	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 12:19:23.2+07
462	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-11 12:38:25.122+07
472	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 13:05:22.273+07
479	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 13:09:58.316+07
481	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 13:12:08.813+07
411	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 09:59:16.615+07
415	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 10:01:26.692+07
419	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 10:04:29.003+07
424	3	0	Aktivitas Pekerjaan	Budiono sedang berada di halaman pekerjaan.	2014-05-11 10:11:51.896+07
426	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-11 10:25:24.668+07
434	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 10:42:49.294+07
442	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 11:24:56.062+07
453	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 12:20:13.686+07
456	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 12:24:26.02+07
416	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-05-11 10:01:42.478+07
417	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 10:02:16.405+07
425	3	0	Aktivitas Pekerjaan	Budiono sedang melihat detail tentang pekerjaannya.	2014-05-11 10:12:10.735+07
431	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 10:38:06.734+07
435	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 10:43:28.21+07
436	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 10:44:03.689+07
445	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-11 11:57:15.012+07
449	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 12:10:10.37+07
459	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-05-11 12:28:37.908+07
466	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 12:58:27.437+07
474	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-11 13:08:09.094+07
475	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 13:08:21.368+07
420	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-05-11 10:09:00.84+07
421	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 10:09:50.387+07
429	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 10:35:29.437+07
430	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 10:37:17.691+07
439	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 10:53:37.685+07
450	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 12:11:56.384+07
463	3	0	Aktivitas Pekerjaan	Budiono sedang berada di halaman pekerjaan.	2014-05-11 12:38:30.458+07
464	3	0	Aktivitas Pekerjaan	Budiono sedang melihat detail tentang pekerjaannya.	2014-05-11 12:38:43.008+07
465	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 12:58:04.406+07
467	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 12:58:38.409+07
478	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-11 13:09:29.629+07
422	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-05-11 10:10:57.663+07
423	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-11 10:11:46.085+07
432	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 10:38:28.663+07
433	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 10:39:22.891+07
437	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 10:48:53.125+07
438	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 10:52:59.468+07
440	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 10:58:05.511+07
443	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 11:28:45.18+07
446	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 11:57:24.122+07
447	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 12:09:17.768+07
448	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 12:09:23.326+07
451	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 12:16:02.751+07
454	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 12:21:15.093+07
455	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 12:24:20.433+07
457	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 12:27:30.764+07
460	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 12:33:35.678+07
470	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 13:02:29.696+07
477	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-11 13:09:22.762+07
482	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 13:13:34.723+07
483	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-11 13:13:46.781+07
484	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 13:16:07.762+07
485	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 13:16:25.885+07
486	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 13:20:27.039+07
487	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 13:22:16.782+07
488	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 13:22:21.313+07
489	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-11 13:22:48.07+07
490	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-11 13:22:55.284+07
491	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-13 15:02:02.594+07
492	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-13 15:11:22.359+07
493	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-13 15:12:54.3+07
494	1	0	Aktivitas Logout	Dr. Bendrong baru saja sgn out dari SI Task Management.	2014-05-13 15:14:20.104+07
495	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-13 15:17:18.347+07
496	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-13 15:17:47.827+07
497	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-13 15:18:29.1+07
498	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-13 15:19:05.477+07
499	1	0	Aktivitas Profil	Dr. Bendrong sedang melihat profil miliknya sendiri..	2014-05-13 15:20:19.343+07
500	1	0	Aktivitas Profil	Dr. Bendrong sedang melihat profil miliknya sendiri..	2014-05-13 15:22:04.012+07
501	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-13 15:22:40.452+07
502	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-13 15:23:25.53+07
503	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-13 15:34:34.727+07
504	1	0	Aktivitas Profil	Dr. Bendrong sedang melihat profil miliknya sendiri..	2014-05-13 15:34:45.155+07
505	1	0	Aktivitas Profil	Dr. Bendrong sedang melihat profil miliknya sendiri..	2014-05-13 15:35:28.49+07
506	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-13 15:35:53.454+07
507	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-13 15:36:59.689+07
508	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-13 15:37:08.539+07
509	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 15:37:35.054+07
510	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-13 15:38:01.014+07
511	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-13 15:38:29.547+07
512	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-13 15:38:52.073+07
513	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 15:39:03.371+07
514	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-13 15:39:31.441+07
515	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-13 15:39:37.15+07
516	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-13 15:39:49.879+07
517	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-13 15:40:06.615+07
518	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-13 15:40:11.121+07
519	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-13 15:41:54.515+07
520	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-13 15:42:15.717+07
521	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 15:43:18.402+07
522	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-13 15:47:39.975+07
523	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-13 15:49:34.048+07
524	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 15:49:56.762+07
525	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 15:51:04.388+07
526	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-13 15:51:16.157+07
527	1	0	Aktivitas Profil	Dr. Bendrong sedang melihat profil miliknya sendiri..	2014-05-13 15:51:20.465+07
528	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-13 15:51:50.241+07
529	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-13 15:52:03.147+07
530	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-13 15:52:17.653+07
535	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-13 16:08:10.157+07
539	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-13 20:28:19.175+07
545	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 21:25:23.307+07
546	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-13 21:38:46.846+07
552	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 22:44:57.644+07
588	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-13 23:53:40.59+07
589	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-13 23:54:00.151+07
591	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-13 23:54:38.268+07
531	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-13 16:00:57.172+07
533	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-13 16:03:10.723+07
534	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-13 16:03:22.906+07
537	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-13 20:27:41.946+07
538	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 20:28:04.275+07
540	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 20:28:22.903+07
541	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-13 20:36:08.796+07
550	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 22:40:53.805+07
555	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 22:47:36.581+07
557	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 22:51:39.108+07
561	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 22:53:56.397+07
577	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 23:47:20.55+07
580	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : Oke terima kasih Pak :D	2014-05-13 23:47:58.1+07
581	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : Oke terima kasih Pak :D	2014-05-13 23:48:48.164+07
592	1	0	Aktivitas Profil	Dr. Bendrong sedang melihat profil miliknya sendiri..	2014-05-13 23:54:47.467+07
532	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-13 16:03:07.429+07
536	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-13 20:27:11.03+07
547	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 21:38:51.865+07
549	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 22:39:17.593+07
562	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-13 23:18:42.035+07
563	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-13 23:18:54.623+07
564	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 23:19:01.332+07
568	3	0	Aktivitas Pekerjaan	Budiono sedang melihat detail tentang pekerjaannya.	2014-05-13 23:19:53.864+07
569	3	0	Aktivitas Komentar	Budiono baru saja memberikan komentar : Iya Pak. Ini sudah hampir 90% selesai. Minggu depan saya jadwalkan selesai Pak. Tks	2014-05-13 23:20:23.306+07
570	3	0	Aktivitas Pekerjaan	Budiono sedang melihat detail tentang pekerjaannya.	2014-05-13 23:23:14.852+07
572	3	0	Aktivitas Pekerjaan	Budiono sedang melihat detail tentang pekerjaannya.	2014-05-13 23:43:08.412+07
573	3	0	Aktivitas Komentar	Budiono baru saja memberikan komentar : halooo	2014-05-13 23:44:24.043+07
574	3	0	Aktivitas Komentar	Budiono baru saja memberikan komentar : Pekerjaan sudah 90%. minggu depan saya targetkan selesai	2014-05-13 23:47:02.949+07
575	3	0	Aktivitas Logout	Budiono baru saja sgn out dari SI Task Management.	2014-05-13 23:47:09.049+07
576	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-13 23:47:16.933+07
590	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-13 23:54:23.475+07
542	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 20:37:19.351+07
553	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 22:45:16.254+07
554	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 22:45:49.806+07
558	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : 	2014-05-13 22:51:48.134+07
559	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : sadasdasd	2014-05-13 22:51:51.099+07
560	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 22:53:17.751+07
587	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 23:53:19.447+07
543	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 20:38:06.889+07
544	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 20:39:52.057+07
548	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 22:38:07.956+07
565	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : Gimana progress pkerjaan ini ?\nSegera diselesaikan yaa.\ntks	2014-05-13 23:19:29.337+07
566	1	0	Aktivitas Logout	Dr. Bendrong baru saja sgn out dari SI Task Management.	2014-05-13 23:19:38.515+07
567	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-13 23:19:49.188+07
571	3	0	Aktivitas Pekerjaan	Budiono sedang melihat detail tentang pekerjaannya.	2014-05-13 23:36:02.88+07
551	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 22:41:20.444+07
556	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 22:51:18.096+07
578	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-13 23:47:39.142+07
579	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 23:47:44.638+07
582	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 23:48:56.182+07
583	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : Oke. Tks :p	2014-05-13 23:49:08.774+07
584	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : Oke. Tks :p	2014-05-13 23:49:15.291+07
585	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : Oke. Tks :p	2014-05-13 23:50:12.041+07
586	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 23:53:01.216+07
593	1	0	Aktivitas Logout	Dr. Bendrong baru saja sgn out dari SI Task Management.	2014-05-13 23:55:15.568+07
594	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-13 23:56:05.717+07
595	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-13 23:56:11.992+07
596	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 23:56:14.559+07
597	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-13 23:56:20.93+07
598	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 23:56:30.185+07
599	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-13 23:58:07.032+07
600	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-13 23:58:11.919+07
601	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-13 23:58:16.789+07
602	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:12:55.688+07
603	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:14:26.923+07
604	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:17:42.971+07
605	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:18:24.781+07
606	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:19:29.057+07
607	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:20:04.64+07
608	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:25:26.851+07
609	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:26:48.522+07
610	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:27:09.161+07
611	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:27:39.981+07
612	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:27:53.8+07
613	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:33:04.667+07
614	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:33:42.315+07
615	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:33:53.11+07
616	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:34:22.457+07
617	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:34:37.094+07
618	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:34:55.011+07
619	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:35:20.391+07
620	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:35:50.011+07
621	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:36:25.19+07
622	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:37:06.012+07
623	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:38:13.424+07
624	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:38:34.922+07
625	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:38:54.935+07
626	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:45:05.226+07
627	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:45:38.551+07
628	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:46:28.695+07
629	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:48:22.307+07
630	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:49:47.833+07
631	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:49:56.429+07
632	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:51:29.318+07
633	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:54:26.723+07
634	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:54:40.499+07
635	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:55:48.205+07
636	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 00:56:15.328+07
637	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : oke pak. mantap	2014-05-14 00:59:52.017+07
638	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : oke pak. mantap	2014-05-14 01:06:32.498+07
639	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : oke pak. mantap	2014-05-14 01:06:34.039+07
640	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : oke pak. mantap	2014-05-14 01:06:35.242+07
641	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : oke pak. mantap	2014-05-14 01:06:36.482+07
642	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : oke pak. mantap	2014-05-14 01:06:37.577+07
643	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 01:10:21.906+07
644	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 01:13:05.526+07
645	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 01:13:37.963+07
646	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 01:14:12.319+07
651	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 01:19:07.941+07
655	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 01:35:49.284+07
667	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 01:59:07.537+07
680	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:07:28.271+07
683	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:10:12.653+07
647	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 01:15:22.69+07
649	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 01:15:51.208+07
660	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 01:49:14.252+07
671	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:02:24.602+07
672	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:02:47.454+07
674	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:04:30.774+07
684	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:11:23.367+07
688	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:16:20.118+07
692	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:21:19.122+07
648	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 01:15:32.428+07
653	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 01:31:46.275+07
669	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:00:39.083+07
677	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:05:46.393+07
678	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:05:53.772+07
696	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:24:26.063+07
700	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:26:31.625+07
650	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 01:18:46.075+07
652	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 01:30:56.492+07
661	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 01:49:41.897+07
673	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:03:01.577+07
681	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:08:37.524+07
685	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:11:38.535+07
687	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:13:33.977+07
689	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:18:09.945+07
699	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:26:18.683+07
654	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 01:33:28.031+07
679	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:06:26.519+07
686	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:12:17.55+07
697	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:24:53.965+07
656	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 01:42:21.408+07
658	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 01:48:02.74+07
675	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:04:36.719+07
693	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:23:11.639+07
657	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 01:47:28.822+07
659	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 01:48:25.077+07
666	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 01:57:30.402+07
668	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 01:59:57.878+07
691	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:21:03.777+07
694	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:23:52.252+07
662	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 01:50:04.973+07
664	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 01:50:47.625+07
670	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:01:41.674+07
690	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:19:00.904+07
695	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:24:09.61+07
698	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:25:55.014+07
663	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 01:50:24.344+07
665	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 01:51:43.152+07
676	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:05:29.19+07
682	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:09:52.693+07
701	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:26:57.205+07
702	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:27:48.239+07
703	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:29:11.737+07
704	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:29:38.668+07
705	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:30:44.549+07
706	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:31:19.38+07
707	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:31:38.258+07
708	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:32:13.79+07
709	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:32:23.159+07
710	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : q	2014-05-14 02:32:34.795+07
711	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqr	2014-05-14 02:32:37.153+07
712	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:32:38.746+07
713	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:32:39.375+07
714	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:32:39.646+07
715	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:32:39.83+07
716	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:32:39.936+07
717	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:32:40.305+07
718	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:32:40.503+07
719	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:33:34.625+07
720	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:33:42.636+07
721	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:33:44.034+07
722	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:33:45.601+07
723	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:33:46.302+07
724	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:33:49.437+07
725	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:33:49.721+07
726	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:33:50.005+07
727	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:33:50.111+07
728	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:33:50.4+07
729	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:13.673+07
730	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:13.918+07
731	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:14.082+07
732	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:14.407+07
733	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:14.464+07
734	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:14.857+07
735	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:14.859+07
736	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:15.084+07
737	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:15.292+07
738	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:15.406+07
739	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:15.923+07
740	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:15.974+07
741	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:16.012+07
742	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:16.313+07
743	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:16.629+07
744	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:16.633+07
745	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:16.726+07
746	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:17.475+07
747	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:17.481+07
748	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:17.481+07
749	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:17.532+07
750	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:17.66+07
751	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:18.624+07
752	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:18.656+07
753	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:18.656+07
754	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:18.659+07
755	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:18.668+07
756	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:18.898+07
757	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:18.969+07
758	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:34:19.77+07
759	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:34:35.956+07
760	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:34:56.472+07
761	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:35:53.15+07
762	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:39:57.58+07
763	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:40:09.067+07
764	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:40:09.959+07
765	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:40:10.629+07
766	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:40:11.292+07
767	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:40:11.934+07
768	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:40:12.556+07
769	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:40:13.225+07
770	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:40:13.733+07
771	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-14 02:41:28.404+07
772	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:42:36.339+07
773	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:42:38.426+07
774	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:42:39.934+07
775	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:42:41.325+07
776	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:42:42.756+07
777	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:42:49.659+07
778	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:43:01.281+07
779	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:43:02.615+07
780	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:43:03.832+07
781	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : qqwrwqrqwrqwr	2014-05-14 02:43:07.673+07
782	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-18 15:26:20.933+07
783	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-18 15:26:30.996+07
784	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-18 15:26:35.736+07
785	1	0	Aktivitas Logout	Dr. Bendrong baru saja sgn out dari SI Task Management.	2014-05-18 15:58:09.64+07
786	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-18 15:58:21.963+07
787	3	0	Aktivitas Pekerjaan	Budiono sedang berada di halaman pekerjaan.	2014-05-18 15:58:31.785+07
788	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-18 15:58:37.009+07
789	3	0	Aktivitas Logout	Budiono baru saja sgn out dari SI Task Management.	2014-05-18 16:02:25.654+07
790	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-18 16:02:33.959+07
791	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-18 16:03:46.527+07
792	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-18 16:03:59.561+07
793	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-18 16:04:10.413+07
794	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-18 16:04:18.955+07
795	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-18 16:05:07.529+07
796	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-18 16:05:32.407+07
797	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-18 16:06:57.671+07
798	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-18 21:54:44.772+07
799	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-24 13:43:04.234+07
800	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-24 13:43:12.841+07
801	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-24 13:53:54.467+07
802	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-24 13:54:15.444+07
803	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-24 13:55:45.839+07
804	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-24 13:56:50.955+07
805	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-24 13:58:19.402+07
806	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-24 13:58:57.8+07
807	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-24 14:01:20.433+07
808	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja memberikan pekerjaan kepada staffnya.	2014-05-24 14:39:19.314+07
809	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-24 14:39:22.209+07
810	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-24 14:39:29.574+07
811	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-24 14:42:28.742+07
812	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-24 16:13:24.226+07
813	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-24 16:14:22.492+07
814	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-24 16:15:07.606+07
815	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-24 16:15:10.959+07
816	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-24 16:15:59.767+07
817	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-24 16:28:58.555+07
818	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-24 16:30:03.477+07
819	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-24 16:30:26.667+07
820	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-24 16:31:14.624+07
821	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-24 16:31:51.947+07
822	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-24 16:32:01.886+07
823	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-24 16:35:53.012+07
824	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-24 16:36:10.863+07
825	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-24 16:36:47.393+07
826	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-24 16:37:48.942+07
827	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-24 16:38:38.918+07
828	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-24 16:40:20.441+07
829	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-24 16:40:35.945+07
830	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-24 16:41:08.762+07
831	6	0	Aktivitas Login	Halal sedang berada di halaman dashboard.	2014-05-24 17:08:08.596+07
832	13	0	Aktivitas Login	Dodo Anondo sedang berada di halaman dashboard.	2014-05-24 18:10:51.273+07
833	13	0	Aktivitas Pekerjaan	Dodo Anondo sedang berada di halaman pekerjaan.	2014-05-24 18:11:03.699+07
834	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-25 11:29:01.963+07
835	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-25 11:29:41.626+07
836	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 11:29:50.445+07
837	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 11:32:35.732+07
838	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 11:33:49.667+07
839	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 11:34:36.45+07
840	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 11:34:55.011+07
841	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 12:26:57.131+07
852	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-25 13:43:02.86+07
854	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-25 13:44:23.876+07
855	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-25 13:47:45.329+07
864	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 13:55:00.681+07
870	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 14:26:11.064+07
874	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 14:28:09.598+07
842	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-25 12:32:36.727+07
860	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 13:51:58.206+07
861	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 13:52:35.392+07
862	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 13:53:16.735+07
867	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-25 14:25:28.678+07
843	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 12:34:47.169+07
846	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 12:42:44.189+07
848	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-25 13:18:23.478+07
849	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 13:18:35.028+07
865	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 13:56:06.307+07
866	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 13:56:23.336+07
872	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 14:27:03.065+07
873	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 14:27:19.96+07
844	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-25 12:40:25.255+07
845	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-25 12:42:30.745+07
847	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 13:10:44.81+07
850	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-25 13:39:09.787+07
851	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 13:39:50.085+07
853	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-25 13:43:57.382+07
856	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 13:48:28.907+07
857	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 13:49:29.845+07
858	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 13:50:04.847+07
859	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 13:51:42.55+07
863	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 13:53:47.324+07
868	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 14:25:47.409+07
869	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 14:26:01.513+07
871	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 14:26:38.325+07
875	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-25 14:32:22.859+07
876	1	0	Aktivitas Logout	Dr. Bendrong baru saja sgn out dari SI Task Management.	2014-05-25 14:47:49.756+07
877	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-25 14:48:22.204+07
878	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-25 17:00:46.128+07
879	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-25 17:01:44.96+07
880	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-25 17:44:53.788+07
881	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-25 17:59:12.202+07
882	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-25 19:04:51.343+07
883	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-25 19:07:39.678+07
884	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-25 19:57:02.988+07
885	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-25 19:57:48.827+07
886	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-25 21:44:06.545+07
887	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-25 21:44:27.913+07
888	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja memberikan pekerjaan kepada staffnya.	2014-05-25 21:46:18.551+07
889	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-25 21:46:18.954+07
890	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-25 21:46:25.174+07
891	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 21:46:41.053+07
892	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 21:46:49.965+07
893	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-25 21:47:25.349+07
894	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-25 21:47:39.592+07
895	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja memberikan pekerjaan kepada staffnya.	2014-05-25 21:51:15.058+07
896	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-25 21:51:15.372+07
897	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-25 22:02:29.779+07
898	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-25 22:02:32.422+07
899	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-25 22:11:13.756+07
900	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja memberikan pekerjaan kepada staffnya.	2014-05-25 22:16:49.584+07
901	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja memberikan pekerjaan kepada staffnya.	2014-05-25 22:17:09.763+07
902	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja memberikan pekerjaan kepada staffnya.	2014-05-25 22:21:10.308+07
903	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-25 22:21:26.943+07
904	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-25 22:21:31.379+07
905	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja memberikan pekerjaan kepada staffnya.	2014-05-25 22:24:44.151+07
906	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-25 22:24:58.165+07
907	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-28 17:11:01.697+07
908	1	0	Aktivitas Profil	Dr. Bendrong sedang melihat profil miliknya sendiri..	2014-05-28 17:11:40.747+07
909	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat laporan pekerjaan dari para staffnya.	2014-05-28 17:11:49.46+07
910	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-28 17:12:26.593+07
911	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-28 17:12:30.292+07
912	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-28 17:12:42.886+07
913	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-28 17:12:50.222+07
914	1	0	Aktivitas Komentar	Dr. Bendrong baru saja memberikan komentar : 	2014-05-28 17:13:25.462+07
915	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-28 17:13:42.652+07
916	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-28 17:14:02.432+07
917	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-28 17:14:33.916+07
918	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-28 17:15:58.462+07
919	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-28 17:16:14.207+07
920	1	0	Aktivitas Profil	Dr. Bendrong sedang melihat profil miliknya sendiri..	2014-05-28 17:21:45.039+07
921	1	0	Aktivitas Logout	Dr. Bendrong baru saja sgn out dari SI Task Management.	2014-05-28 17:22:04.41+07
922	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-28 17:22:34.479+07
923	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat laporan pekerjaan dari para staffnya.	2014-05-28 17:22:56.786+07
924	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat laporan pekerjaan per periode dari para staffnya.	2014-05-28 17:23:52.967+07
925	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat laporan pekerjaan per periode dari para staffnya.	2014-05-28 17:25:40.962+07
926	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat laporan pekerjaan dari para staffnya.	2014-05-28 17:25:47.397+07
927	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat laporan pekerjaan per periode dari para staffnya.	2014-05-28 17:25:58.425+07
928	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat laporan pekerjaan dari para staffnya.	2014-05-28 17:27:01.535+07
929	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat laporan pekerjaan dari para staffnya.	2014-05-28 17:27:22.81+07
930	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-28 17:28:54.882+07
931	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-28 17:30:23.675+07
932	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-28 17:32:02.059+07
933	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-28 17:33:42.471+07
934	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat laporan pekerjaan dari para staffnya.	2014-05-28 17:33:49.273+07
935	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-28 17:33:58.137+07
936	1	0	Aktivitas Profil	Dr. Bendrong sedang melihat profil miliknya sendiri..	2014-05-28 17:34:09.116+07
937	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat laporan pekerjaan dari para staffnya.	2014-05-28 17:44:16.569+07
938	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat laporan pekerjaan dari para staffnya.	2014-05-28 17:58:15.675+07
939	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat laporan pekerjaan dari para staffnya.	2014-05-28 17:59:37.588+07
940	1	0	Aktivitas Logout	Dr. Bendrong baru saja sgn out dari SI Task Management.	2014-05-28 19:34:59.386+07
941	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-28 19:35:05.934+07
942	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-28 19:45:55.174+07
943	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-28 19:46:19.65+07
944	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-28 20:00:45.553+07
945	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-28 20:01:38.166+07
946	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-28 20:06:03.968+07
947	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-28 20:07:53.734+07
948	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-28 20:10:49.846+07
949	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-28 20:13:28.362+07
950	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-28 20:16:54.627+07
951	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-28 20:21:44.52+07
952	3	0	Aktivitas Logout	Budiono baru saja sgn out dari SI Task Management.	2014-05-28 20:22:59.136+07
953	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-28 20:23:04.145+07
954	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat laporan pekerjaan dari para staffnya.	2014-05-28 20:24:02.274+07
955	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat laporan pekerjaan per periode dari para staffnya.	2014-05-28 20:24:22.736+07
956	1	0	Aktivitas Logout	Dr. Bendrong baru saja sgn out dari SI Task Management.	2014-05-28 20:26:08.692+07
957	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-28 20:33:40.003+07
958	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-28 20:44:25.732+07
959	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-28 21:46:34.816+07
960	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja memberikan pekerjaan kepada staffnya.	2014-05-29 00:48:52.216+07
961	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-29 00:49:15.824+07
962	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 00:49:27.804+07
963	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-29 00:49:52.543+07
964	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-29 00:50:00.122+07
965	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 00:50:02.909+07
966	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 00:50:05.892+07
967	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 00:55:32.489+07
974	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 01:04:40.605+07
977	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja memberikan pekerjaan kepada staffnya.	2014-05-29 01:25:01.647+07
968	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 00:56:56.233+07
970	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 00:57:53.94+07
973	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 01:00:39.782+07
976	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 01:06:38.939+07
979	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 01:29:18.251+07
969	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 00:57:17.164+07
971	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 00:58:40.153+07
972	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 01:00:10.447+07
975	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 01:05:29.941+07
978	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja memberikan pekerjaan kepada staffnya.	2014-05-29 01:29:08.646+07
980	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-29 01:29:48.232+07
981	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 08:31:41.391+07
982	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-29 08:31:50.567+07
983	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 08:31:56.682+07
984	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 08:32:27.041+07
985	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 08:35:07.831+07
986	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 08:35:25.78+07
987	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 08:38:19.678+07
988	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 08:47:04.513+07
989	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 08:47:32.963+07
990	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 08:48:57.245+07
991	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-29 08:49:08.41+07
992	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 08:49:31.421+07
993	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 08:51:58.16+07
994	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 08:52:58.14+07
995	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 08:55:58.812+07
996	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-29 08:56:26.864+07
997	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 08:58:55.849+07
998	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 08:59:44.548+07
999	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 09:03:37.173+07
1000	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 09:04:24.563+07
1001	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 09:04:49.868+07
1002	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 09:05:32.576+07
1003	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 09:06:07.727+07
1004	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 09:11:36.582+07
1005	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 09:16:26.833+07
1006	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 09:20:46.209+07
1007	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 09:25:20.505+07
1008	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 09:31:48.814+07
1009	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 09:33:41.406+07
1010	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 09:34:47.617+07
1011	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 09:40:15.65+07
1012	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 09:42:10.478+07
1013	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 09:56:58.967+07
1014	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 10:01:53.077+07
1015	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 10:02:48.316+07
1016	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 10:03:39.222+07
1017	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 10:40:27.357+07
1018	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 10:53:43.25+07
1019	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 10:55:52.664+07
1020	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 10:57:15.28+07
1021	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 10:57:44.591+07
1022	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 10:58:59.165+07
1023	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 16:14:27.806+07
1024	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 16:16:15.582+07
1025	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-29 16:36:12.213+07
1026	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 16:36:23.869+07
1027	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 19:24:13.995+07
1028	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 19:27:47.871+07
1029	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 19:28:18.83+07
1030	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 19:29:12.153+07
1031	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 19:30:12.841+07
1032	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 19:32:44.268+07
1034	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 20:35:46.615+07
1039	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 20:44:21.847+07
1045	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat laporan pekerjaan dari para staffnya.	2014-05-29 21:27:46.329+07
1046	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-29 21:33:04.592+07
1048	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-29 21:39:40.536+07
1049	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 22:35:14.529+07
1052	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 22:48:38.253+07
1054	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 22:49:40.404+07
1055	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 22:52:04.839+07
1056	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 22:55:03.466+07
1058	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 22:56:24.212+07
1059	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 22:59:08.261+07
1061	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 23:00:58.097+07
1063	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 23:02:37.156+07
1065	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-29 23:03:19.131+07
1068	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 23:13:09.733+07
1074	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 23:19:46.231+07
1075	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 23:26:05.589+07
1076	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-29 23:30:17.115+07
1077	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 23:30:28.428+07
1085	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 23:39:20.773+07
1086	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 23:41:02.654+07
1087	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 23:49:28.912+07
1090	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 23:56:40.31+07
1103	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-30 00:32:52.68+07
1104	13	0	Aktivitas Login	Dodo Anondo sedang berada di halaman dashboard.	2014-05-30 00:35:41.56+07
1107	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 00:38:54.362+07
1108	13	0	Aktivitas Pekerjaan	Dodo Anondo sedang melihat detail tentang pekerjaannya.	2014-05-30 00:40:02.863+07
1109	13	0	Aktivitas Pekerjaan	Dodo Anondo sedang melihat detail tentang pekerjaannya.	2014-05-30 00:40:28.573+07
1119	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 00:51:01.426+07
1121	11	0	Aktivitas Login	Felix sedang berada di halaman dashboard.	2014-05-30 01:12:27.711+07
1122	11	0	Aktivitas Login	Felix sedang berada di halaman dashboard.	2014-05-30 01:12:54.728+07
1127	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-30 01:17:29.162+07
1128	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-30 01:17:50.278+07
1033	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 19:49:55.214+07
1035	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 20:36:39.234+07
1041	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 20:47:32.824+07
1043	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 20:51:26.833+07
1047	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 21:33:23.764+07
1050	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 22:47:19.763+07
1051	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 22:48:12.778+07
1064	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 23:02:52.201+07
1083	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-29 23:34:52.848+07
1091	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 23:57:18.551+07
1094	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 23:58:02.651+07
1095	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 00:00:13.791+07
1110	13	0	Aktivitas Logout	Dodo Anondo baru saja sgn out dari SI Task Management.	2014-05-30 00:40:39.338+07
1111	11	0	Aktivitas Login	Felix sedang berada di halaman dashboard.	2014-05-30 00:41:02.052+07
1126	11	0	Aktivitas Pekerjaan	Felix sedang melihat detail tentang pekerjaannya.	2014-05-30 01:15:40.396+07
1129	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 01:17:59.637+07
1036	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-29 20:39:03.535+07
1037	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 20:39:18.509+07
1038	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 20:43:19.671+07
1067	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 23:07:37.402+07
1069	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 23:14:13.119+07
1078	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-29 23:30:59.996+07
1079	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 23:31:43.672+07
1082	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-29 23:33:11.946+07
1092	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 23:57:33.811+07
1093	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 23:57:54.544+07
1096	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-05-30 00:00:26.12+07
1097	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 00:03:11.657+07
1100	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 00:11:32.947+07
1112	11	0	Aktivitas Pekerjaan	Felix sedang melihat detail tentang pekerjaannya.	2014-05-30 00:41:34.415+07
1120	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 01:07:05.904+07
1125	11	0	Aktivitas Pekerjaan	Felix sedang melihat detail tentang pekerjaannya.	2014-05-30 01:14:24.836+07
1040	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 20:46:44.279+07
1042	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 20:48:18.201+07
1044	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 21:24:53.65+07
1053	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 22:49:13.909+07
1057	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 22:55:30.474+07
1060	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 22:59:45.022+07
1062	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 23:02:21.319+07
1066	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-05-29 23:07:23.962+07
1070	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 23:15:31.804+07
1071	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 23:16:06.64+07
1072	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-29 23:18:46.464+07
1073	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 23:18:55.769+07
1080	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-29 23:32:00.494+07
1081	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 23:32:39.006+07
1084	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-29 23:35:23.247+07
1088	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 23:55:11.464+07
1089	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-29 23:55:35.128+07
1098	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 00:03:23.116+07
1099	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 00:05:24.82+07
1101	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 00:31:21.812+07
1102	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 00:32:29.641+07
1105	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 00:37:19.292+07
1106	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 00:37:59.771+07
1113	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 00:42:46.399+07
1114	11	0	Aktivitas Pekerjaan	Felix sedang melihat detail tentang pekerjaannya.	2014-05-30 00:43:05.652+07
1115	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-30 00:43:34.702+07
1116	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-30 00:44:41.579+07
1117	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 00:44:49.638+07
1118	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 00:45:04.246+07
1123	11	0	Aktivitas Pekerjaan	Felix sedang melihat detail tentang pekerjaannya.	2014-05-30 01:13:02.029+07
1124	11	0	Aktivitas Pekerjaan	Felix sedang melihat detail tentang pekerjaannya.	2014-05-30 01:13:46.672+07
1130	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 01:19:45.83+07
1131	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 01:20:40.71+07
1132	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 01:21:00.6+07
1133	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 01:27:29.013+07
1134	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 01:28:14.353+07
1135	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-30 01:29:00.538+07
1136	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-30 01:31:25.425+07
1137	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 01:31:33.807+07
1138	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-30 08:40:55.027+07
1139	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 08:46:38.505+07
1140	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 08:46:48.477+07
1141	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 08:47:27.552+07
1142	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-30 09:52:00.568+07
1143	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-30 09:57:05.572+07
1144	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 09:57:11.205+07
1145	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 09:57:14.421+07
1146	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 09:59:57.604+07
1147	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 10:00:28.602+07
1148	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 10:03:38.403+07
1149	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 10:05:44.325+07
1150	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 10:06:07.153+07
1151	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 10:07:03.282+07
1152	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 10:08:00.936+07
1153	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 10:08:50.714+07
1154	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 10:10:00.155+07
1155	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 10:11:22.871+07
1156	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 10:13:10.57+07
1157	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 10:13:56.797+07
1158	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 10:14:36.997+07
1159	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 10:21:10.017+07
1160	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 10:22:11.971+07
1161	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 10:24:05.491+07
1162	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 10:24:58.888+07
1163	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 10:25:33.924+07
1164	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 10:27:06.528+07
1165	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 10:27:36.534+07
1166	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 10:31:04.104+07
1167	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 10:31:42.696+07
1172	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 10:38:27.153+07
1173	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 10:40:02.184+07
1174	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 10:40:15.343+07
1175	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 10:40:31.281+07
1176	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 10:40:59.568+07
1179	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 10:44:02.014+07
1184	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 10:45:55.995+07
1185	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-30 10:47:08.35+07
1189	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-30 10:55:37.567+07
1168	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 10:31:53.465+07
1169	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 10:33:13.956+07
1170	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 10:34:29.993+07
1171	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 10:37:03.948+07
1178	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 10:44:01.743+07
1181	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-30 10:44:38.344+07
1182	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-30 10:45:35.59+07
1186	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-30 10:53:09.838+07
1198	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-30 10:59:36.28+07
1200	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-30 11:01:18.088+07
1203	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 11:01:49.288+07
1204	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-30 11:01:57.331+07
1177	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-30 10:43:53.544+07
1190	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-30 10:55:54.077+07
1180	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-05-30 10:44:29.906+07
1188	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-30 10:55:26.25+07
1191	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-30 10:57:11.137+07
1192	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-30 10:57:30.223+07
1193	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-30 10:57:42.961+07
1194	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-30 10:57:59.111+07
1195	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-30 10:58:08.79+07
1196	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-30 10:58:15.784+07
1197	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-30 10:58:18.554+07
1201	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 11:01:26.264+07
1202	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 11:01:33.193+07
1183	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 10:45:44.591+07
1187	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-30 10:53:46.442+07
1199	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-30 11:01:10.562+07
1205	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-30 14:39:43.081+07
1206	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-30 14:42:06.235+07
1207	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-30 14:42:15.451+07
1208	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-30 14:42:49.791+07
1209	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-30 14:43:01.847+07
1210	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-05-30 14:48:44.726+07
1211	3	0	Aktivitas Logout	Budiono baru saja sgn out dari SI Task Management.	2014-05-30 14:49:03.023+07
1212	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-30 14:49:09.989+07
1213	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 14:49:35.185+07
1214	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 14:51:19.084+07
1215	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 14:51:54.874+07
1216	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 14:52:59.519+07
1217	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 14:53:09.424+07
1218	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 14:58:30.056+07
1219	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-05-30 15:37:16.663+07
1220	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 15:38:32.452+07
1221	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja membuat draft pekerjaan.	2014-05-30 16:24:44.083+07
1222	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja membuat draft pekerjaan.	2014-05-30 16:38:53.174+07
1223	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja membuat draft pekerjaan.	2014-05-30 16:39:04.492+07
1224	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-05-30 16:40:20.449+07
1225	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-05-30 16:40:24.81+07
1226	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-05-30 16:40:54.236+07
1227	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-01 08:55:16.931+07
1228	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-01 09:18:18.936+07
1229	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-01 09:19:13.449+07
1230	2	0	Aktivitas Login	Aris sedang berada di halaman dashboard.	2014-06-01 09:22:02.641+07
1231	2	0	Aktivitas Login	Aris sedang berada di halaman dashboard.	2014-06-01 09:23:36.135+07
1232	2	0	Aktivitas Login	Aris sedang berada di halaman dashboard.	2014-06-01 09:26:00.497+07
1233	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-01 09:26:07.125+07
1234	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-01 09:28:42.852+07
1235	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-01 09:30:56.373+07
1236	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-01 09:31:30.022+07
1237	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-01 09:32:57.587+07
1238	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-01 09:34:09.855+07
1239	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-01 09:35:05.945+07
1240	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-01 09:36:20.033+07
1241	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-01 09:36:46.76+07
1242	2	0	Aktivitas Pekerjaan	Aris sedang melihat detail tentang pekerjaannya.	2014-06-01 09:39:47.592+07
1243	2	0	Aktivitas Pekerjaan	Aris sedang melihat detail tentang pekerjaannya.	2014-06-01 09:40:59.112+07
1244	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-01 09:41:12.839+07
1245	2	0	Aktivitas Pekerjaan	Aris sedang melihat detail tentang pekerjaannya.	2014-06-01 09:41:32.089+07
1246	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-01 10:36:13.682+07
1247	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-01 11:22:16.013+07
1248	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-01 11:23:25.007+07
1249	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-01 11:25:09.012+07
1250	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-01 11:29:02.119+07
1251	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-01 12:46:43.009+07
1252	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-01 12:47:26.95+07
1253	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-01 12:48:06.467+07
1254	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-01 12:52:16.784+07
1255	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-01 12:59:43.103+07
1256	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-01 13:05:43.771+07
1257	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-01 13:06:34.038+07
1258	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-01 13:07:37.112+07
1259	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-01 13:10:26.406+07
1260	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-01 13:10:33.828+07
1261	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-01 13:20:34.173+07
1262	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-01 13:22:02.093+07
1263	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-01 13:23:03.029+07
1264	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-01 13:24:09.085+07
1265	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-01 13:24:38.391+07
1266	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-01 13:25:02.071+07
1267	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-01 13:25:38.28+07
1268	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-01 13:26:46.124+07
1269	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-01 13:27:00.127+07
1270	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-01 13:27:12.018+07
1271	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-01 13:27:17.871+07
1272	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-01 13:30:31.186+07
1274	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-01 13:35:08.757+07
1277	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-01 13:41:49.532+07
1273	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-01 13:34:25.772+07
1275	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-01 13:37:31.813+07
1276	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-01 13:40:07.171+07
1278	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-01 17:11:20.033+07
1279	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-01 17:12:00.4+07
1280	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-01 17:14:56.084+07
1281	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-01 17:19:28.691+07
1282	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-01 17:20:29.335+07
1283	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-01 17:20:34.761+07
1284	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-06-01 17:21:11.035+07
1285	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-01 17:21:21.732+07
1286	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-01 18:36:08.162+07
1287	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-01 20:38:26.176+07
1288	1	0	Aktivitas Logout	Dr. Bendrong baru saja sgn out dari SI Task Management.	2014-06-01 20:39:04.912+07
1289	4	0	Aktivitas Login	Joko sedang berada di halaman dashboard.	2014-06-01 20:40:08.647+07
1290	4	0	Aktivitas Pekerjaan	Joko sedang melihat progress pekerjaan dari para staffnya.	2014-06-01 20:40:39.52+07
1291	4	0	Aktivitas Pekerjaan	Joko baru saja memberikan pekerjaan kepada staffnya.	2014-06-01 20:55:37.736+07
1292	4	0	Aktivitas Pekerjaan	Joko sedang melihat progress pekerjaan dari para staffnya.	2014-06-01 20:55:37.982+07
1293	4	0	Aktivitas Pekerjaan	Joko sedang melihat progress pekerjaan dari para staffnya.	2014-06-01 20:56:31.795+07
1294	4	0	Aktivitas Login	Joko sedang berada di halaman dashboard.	2014-06-01 20:56:45.976+07
1295	4	0	Aktivitas Pekerjaan	Joko sedang melihat progress pekerjaan dari para staffnya.	2014-06-01 20:57:17.337+07
1296	4	0	Aktivitas Pekerjaan	Joko baru saja memberikan pekerjaan kepada staffnya.	2014-06-01 20:57:38.185+07
1297	4	0	Aktivitas Pekerjaan	Joko sedang melihat progress pekerjaan dari para staffnya.	2014-06-01 20:57:38.313+07
1298	4	0	Aktivitas Login	Joko sedang berada di halaman dashboard.	2014-06-01 21:03:01.18+07
1299	4	0	Aktivitas Login	Joko sedang berada di halaman dashboard.	2014-06-01 21:04:12.241+07
1300	4	0	Aktivitas Pekerjaan	Joko sedang melihat progress pekerjaan dari para staffnya.	2014-06-01 21:04:23.273+07
1301	4	0	Aktivitas Pekerjaan	Joko baru saja memberikan pekerjaan kepada staffnya.	2014-06-01 21:04:49.963+07
1302	4	0	Aktivitas Pekerjaan	Joko baru saja memberikan pekerjaan kepada staffnya.	2014-06-01 21:05:10.337+07
1303	4	0	Aktivitas Pekerjaan	Joko sedang melihat progress pekerjaan dari para staffnya.	2014-06-01 21:05:10.635+07
1304	4	0	Aktivitas Login	Joko sedang berada di halaman dashboard.	2014-06-01 22:03:18.833+07
1305	4	0	Aktivitas Pekerjaan	Joko sedang berada di halaman pekerjaan.	2014-06-01 22:03:30.85+07
1306	4	0	Aktivitas Pekerjaan	Joko baru saja mengusulkan pekerjaan.	2014-06-01 22:04:20.043+07
1307	4	0	Aktivitas Pekerjaan	Joko sedang berada di halaman pekerjaan.	2014-06-01 22:04:20.59+07
1308	4	0	Aktivitas Login	Joko sedang berada di halaman dashboard.	2014-06-01 22:04:44.277+07
1309	4	0	Aktivitas Pekerjaan	Joko sedang berada di halaman pekerjaan.	2014-06-01 22:05:02.172+07
1310	4	0	Aktivitas Pekerjaan	Joko sedang melihat progress pekerjaan dari para staffnya.	2014-06-01 22:12:50.732+07
1311	11	0	Aktivitas Login	Felix sedang berada di halaman dashboard.	2014-06-02 22:40:47.63+07
1312	11	0	Aktivitas Pekerjaan	Felix sedang berada di halaman pekerjaan.	2014-06-02 22:41:08.456+07
1313	11	0	Aktivitas Logout	Felix baru saja sgn out dari SI Task Management.	2014-06-02 22:42:27.007+07
1314	4	0	Aktivitas Login	Joko sedang berada di halaman dashboard.	2014-06-02 22:42:37.955+07
1315	4	0	Aktivitas Pekerjaan	Joko sedang melihat progress pekerjaan dari para staffnya.	2014-06-02 22:42:44.179+07
1316	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-02 22:44:45.719+07
1317	4	0	Aktivitas Pekerjaan	Joko sedang berada di halaman pekerjaan.	2014-06-02 23:07:06.796+07
1318	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-06-02 23:09:13.497+07
1319	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-02 23:09:21.66+07
1320	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-02 23:12:27.898+07
1321	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-02 23:12:44.407+07
1322	4	0	Aktivitas Login	Joko sedang berada di halaman dashboard.	2014-06-02 23:13:08.999+07
1323	4	0	Aktivitas Pekerjaan	Joko sedang melihat progress pekerjaan dari para staffnya.	2014-06-02 23:13:16.104+07
1324	4	0	Aktivitas Pekerjaan	Joko baru saja memberikan pekerjaan kepada staffnya.	2014-06-02 23:13:55.949+07
1325	4	0	Aktivitas Pekerjaan	Joko sedang melihat progress pekerjaan dari para staffnya.	2014-06-02 23:13:56.07+07
1326	4	0	Aktivitas Pekerjaan	Joko sedang melihat detail tentang pekerjaannya.	2014-06-02 23:14:12.608+07
1327	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-02 23:15:27.162+07
1328	4	0	Aktivitas Pekerjaan	Joko sedang melihat detail tentang pekerjaannya.	2014-06-02 23:18:38.159+07
1329	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-06-02 23:34:41.42+07
1330	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-02 23:52:35.463+07
1331	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-02 23:53:24.777+07
1332	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-02 23:53:35.473+07
1333	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-02 23:53:42.946+07
1334	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-02 23:54:06.236+07
1335	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-06-02 23:54:21.934+07
1336	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-06-02 23:54:25.777+07
1337	4	0	Aktivitas Pekerjaan	Joko sedang berada di halaman pekerjaan.	2014-06-02 23:54:33.568+07
1338	4	0	Aktivitas Pekerjaan	Joko sedang melihat detail tentang pekerjaannya.	2014-06-02 23:56:44.892+07
1339	4	0	Aktivitas Pekerjaan	Joko sedang melihat detail tentang pekerjaannya.	2014-06-02 23:57:20.902+07
1340	4	0	Aktivitas Pekerjaan	Joko baru saja melakukan perubahan pada detail pekerjaan.	2014-06-02 23:57:33.28+07
1341	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-06-03 00:01:13.199+07
1342	4	0	Aktivitas Pekerjaan	Joko baru saja melakukan perubahan pada detail pekerjaan.	2014-06-03 00:01:17.3+07
1343	4	0	Aktivitas Pekerjaan	Joko baru saja melakukan perubahan pada detail pekerjaan.	2014-06-03 00:02:18.352+07
1344	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-06-03 00:03:28.217+07
1345	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-03 00:03:55.283+07
1346	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-03 00:03:59.544+07
1349	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-03 00:19:03.442+07
1350	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-03 00:19:11.902+07
1354	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-03 00:21:51.247+07
1355	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-03 00:22:19.834+07
1358	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-03 00:23:41.526+07
1361	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-03 00:25:23.649+07
1364	4	0	Aktivitas Pekerjaan	Joko sedang melihat detail tentang pekerjaannya.	2014-06-03 00:28:37.203+07
1365	4	0	Aktivitas Pekerjaan	Joko baru saja melakukan perubahan pada detail pekerjaan.	2014-06-03 00:28:47.16+07
1366	4	0	Aktivitas Pekerjaan	Joko sedang melihat detail tentang pekerjaannya.	2014-06-03 00:47:49.035+07
1372	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-03 00:50:26.119+07
1373	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-03 00:51:47.631+07
1378	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-03 01:00:49.967+07
1388	4	0	Aktivitas Pekerjaan	Joko sedang melihat detail tentang pekerjaannya.	2014-06-03 01:20:13.242+07
1389	4	0	Aktivitas Pekerjaan	Joko sedang melihat detail tentang pekerjaannya.	2014-06-03 01:21:36.463+07
1390	4	0	Aktivitas Pekerjaan	Joko sedang melihat detail tentang pekerjaannya.	2014-06-03 01:21:50.444+07
1347	4	0	Aktivitas Pekerjaan	Joko baru saja melakukan perubahan pada detail pekerjaan.	2014-06-03 00:16:20.815+07
1348	4	0	Aktivitas Pekerjaan	Joko baru saja melakukan perubahan pada detail pekerjaan.	2014-06-03 00:18:42.574+07
1351	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-03 00:20:58.071+07
1352	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-03 00:21:27.459+07
1353	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-03 00:21:32.752+07
1356	4	0	Aktivitas Pekerjaan	Joko sedang melihat detail tentang pekerjaannya.	2014-06-03 00:22:27.229+07
1357	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-03 00:22:43.746+07
1359	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-03 00:24:39.093+07
1360	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-03 00:24:55.552+07
1362	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-03 00:26:49.777+07
1363	4	0	Aktivitas Pekerjaan	Joko sedang berada di halaman pekerjaan.	2014-06-03 00:28:30.399+07
1367	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-03 00:48:03.576+07
1368	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-03 00:48:45.312+07
1375	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-03 00:53:22.224+07
1376	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-03 00:58:41.162+07
1377	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-03 00:59:41.015+07
1379	4	0	Aktivitas Pekerjaan	Joko sedang melihat detail tentang pekerjaannya.	2014-06-03 01:02:06.541+07
1380	4	0	Aktivitas Pekerjaan	Joko baru saja melakukan perubahan pada detail pekerjaan.	2014-06-03 01:02:35.631+07
1381	4	0	Aktivitas Pekerjaan	Joko sedang melihat detail tentang pekerjaannya.	2014-06-03 01:02:51.829+07
1382	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-03 01:03:15.231+07
1384	4	0	Aktivitas Pekerjaan	Joko baru saja melakukan perubahan pada detail pekerjaan.	2014-06-03 01:03:31.028+07
1385	4	0	Aktivitas Pekerjaan	Joko baru saja melakukan perubahan pada detail pekerjaan.	2014-06-03 01:03:53.518+07
1386	4	0	Aktivitas Pekerjaan	Joko sedang melihat detail tentang pekerjaannya.	2014-06-03 01:04:27.231+07
1369	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-03 00:48:58.244+07
1370	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-03 00:49:57.254+07
1371	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-03 00:50:13.459+07
1374	4	0	Aktivitas Pekerjaan	Joko sedang melihat detail tentang pekerjaannya.	2014-06-03 00:51:58.511+07
1383	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-06-03 01:03:24.186+07
1387	4	0	Aktivitas Pekerjaan	Joko sedang melihat detail tentang pekerjaannya.	2014-06-03 01:17:33.666+07
1391	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-03 09:13:54.433+07
1392	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-03 09:15:07.706+07
1393	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-03 09:15:57.891+07
1394	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-03 09:16:29.455+07
1395	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-03 09:17:59.491+07
1396	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 17:19:12.391+07
1397	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-04 17:19:20.976+07
1398	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-04 17:19:25.726+07
1399	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-04 17:19:54.726+07
1400	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-04 17:20:35.297+07
1401	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-04 18:13:39.035+07
1402	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-04 18:15:10.724+07
1403	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 18:29:40.555+07
1404	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-04 18:29:47.097+07
1405	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-04 18:30:04.993+07
1406	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-04 18:33:46.247+07
1407	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-04 18:40:30.772+07
1408	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-04 19:01:08.08+07
1409	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-04 19:01:32.23+07
1410	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-04 19:03:17.618+07
1411	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-04 19:03:41.395+07
1412	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-04 19:04:44.153+07
1413	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-04 19:07:23.6+07
1414	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-04 19:07:44.174+07
1415	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-04 19:07:51.094+07
1416	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-04 19:09:10.06+07
1417	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-04 19:09:25.224+07
1418	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-04 19:10:09.046+07
1419	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-04 19:10:49.471+07
1420	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-04 19:14:36.776+07
1421	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-04 19:44:47.486+07
1422	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-04 20:00:13.733+07
1423	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-04 20:00:38.544+07
1424	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 20:04:31.58+07
1425	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-06-04 20:05:49.877+07
1426	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 20:13:54.549+07
1427	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 20:18:20.941+07
1428	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 20:25:41.643+07
1429	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 20:29:22.798+07
1430	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 20:41:23.052+07
1431	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 20:43:07.203+07
1432	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 20:43:40.679+07
1433	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 20:45:44.878+07
1434	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 20:47:53.376+07
1435	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 20:49:26.661+07
1436	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 20:58:01.4+07
1437	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 20:58:41.47+07
1438	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 20:58:54.626+07
1439	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 21:00:15.647+07
1440	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 21:01:06.279+07
1441	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 21:03:14.177+07
1442	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 21:03:50.167+07
1443	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 21:04:46.344+07
1444	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 21:05:18.542+07
1445	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 21:06:38.926+07
1446	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 21:08:02.817+07
1447	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 21:12:34.714+07
1448	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 21:13:06.979+07
1449	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 21:20:33.619+07
1450	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 21:29:37.305+07
1453	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 22:25:53.556+07
1454	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 22:26:40.252+07
1455	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 22:29:11.627+07
1456	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-04 22:32:25.461+07
1459	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-04 22:38:20.061+07
1460	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-04 22:38:28.709+07
1461	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-04 22:38:33.613+07
1465	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-04 22:42:03.252+07
1466	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-04 22:42:06.328+07
1467	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-04 22:53:52.075+07
1451	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 22:17:47.618+07
1452	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 22:19:05.067+07
1457	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-04 22:36:58.734+07
1458	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-04 22:37:44.464+07
1462	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-04 22:40:54.602+07
1463	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-04 22:41:11.757+07
1464	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-04 22:41:22.261+07
1468	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja mengusulkan pekerjaan.	2014-06-04 22:54:27.513+07
1469	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-04 22:54:27.875+07
1470	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja mengusulkan pekerjaan.	2014-06-04 22:55:51.477+07
1471	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-04 22:55:51.861+07
1472	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-04 22:57:07.619+07
1473	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-06-04 22:57:52.258+07
1474	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-06-04 22:57:58.169+07
1475	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 23:48:11.689+07
1476	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-06-04 23:48:40.271+07
1477	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-04 23:49:03.79+07
1478	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-04 23:49:09.449+07
1479	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-04 23:49:27.451+07
1480	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 23:50:47.835+07
1481	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-04 23:51:07.423+07
1482	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 23:53:14.224+07
1483	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-04 23:53:24.69+07
1484	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-04 23:53:30.764+07
1485	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-04 23:53:34.131+07
1486	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-04 23:55:21.638+07
1487	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-04 23:55:27.948+07
1488	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-04 23:55:37.593+07
1489	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-04 23:56:21.591+07
1490	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-04 23:56:25.893+07
1491	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-04 23:56:44.351+07
1492	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-04 23:56:47.513+07
1493	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-04 23:56:57.884+07
1494	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-04 23:57:02.65+07
1495	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-04 23:57:05.644+07
1496	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-04 23:57:30.659+07
1497	1	0	Aktivitas Profil	Dr. Bendrong sedang melihat profil miliknya sendiri..	2014-06-04 23:57:56.972+07
1498	1	0	Aktivitas Profil	Dr. Bendrong sedang melihat profil miliknya sendiri..	2014-06-04 23:58:17.328+07
1499	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-04 23:58:24.966+07
1500	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-04 23:58:29.265+07
1501	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-04 23:58:34.811+07
1502	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-04 23:58:46.328+07
1503	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-04 23:59:08.103+07
1504	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-04 23:59:23.115+07
1505	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat laporan pekerjaan dari para staffnya.	2014-06-05 00:00:04.243+07
1506	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat laporan pekerjaan per periode dari para staffnya.	2014-06-05 00:00:18.409+07
1507	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat laporan pekerjaan per periode dari para staffnya.	2014-06-05 00:00:21.356+07
1508	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat laporan pekerjaan per periode dari para staffnya.	2014-06-05 00:00:34.176+07
1509	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-05 00:01:41.643+07
1510	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-05 00:01:58.42+07
1511	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-06-05 00:02:21.415+07
1512	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-06-05 00:02:23.032+07
1513	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-06-05 00:05:22.142+07
1514	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-06-05 00:05:26.595+07
1515	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-05 00:06:03.362+07
1516	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-05 00:06:21.917+07
1517	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-06-05 00:06:43.862+07
1518	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-05 00:06:47.23+07
1519	1	0	Aktivitas Profil	Dr. Bendrong sedang melihat profil miliknya sendiri..	2014-06-05 00:06:50.423+07
1520	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-05 00:08:30.83+07
1521	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-05 00:09:40.453+07
1522	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-05 00:09:46.453+07
1523	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-05 00:10:06.125+07
1524	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-05 00:10:11.084+07
1525	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-05 00:10:13.65+07
1526	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-05 00:11:30.948+07
1527	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-05 00:11:37.089+07
1528	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-05 00:11:40.825+07
1529	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-05 00:11:45.538+07
1530	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-06-05 00:11:50.656+07
1531	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-06-05 00:12:10.742+07
1532	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-05 00:16:01.762+07
1533	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-05 00:16:07.785+07
1534	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja mengusulkan pekerjaan.	2014-06-05 00:16:26.589+07
1535	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-05 00:16:26.957+07
1536	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-05 00:16:36.63+07
1537	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-05 00:16:43.267+07
1538	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-05 00:16:58.424+07
1555	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-05 00:24:34.113+07
1539	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-05 00:17:09.182+07
1540	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-05 00:17:19.534+07
1541	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-05 00:17:37.089+07
1542	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-05 00:17:44.574+07
1543	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-05 00:17:49.071+07
1544	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-05 00:18:08.121+07
1545	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-05 00:18:18.431+07
1546	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-05 00:18:33.689+07
1547	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-05 00:18:38.004+07
1548	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-05 00:18:43.391+07
1549	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-05 00:21:02.907+07
1550	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-05 00:21:05.685+07
1551	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-06-05 00:23:36.039+07
1552	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-05 00:23:39.158+07
1553	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-05 00:23:45.735+07
1554	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-05 00:24:22.775+07
1556	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-05 00:24:47.114+07
1557	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-05 00:25:00.477+07
1558	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-05 00:25:11.549+07
1559	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat laporan pekerjaan dari para staffnya.	2014-06-05 00:25:33.463+07
1560	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat laporan pekerjaan per periode dari para staffnya.	2014-06-05 00:26:35.212+07
1561	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat laporan pekerjaan per periode dari para staffnya.	2014-06-05 00:26:36.128+07
1562	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat laporan pekerjaan dari para staffnya.	2014-06-05 00:28:13.221+07
1563	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-05 00:51:43.691+07
1564	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang berada di halaman pekerjaan.	2014-06-05 00:52:22.936+07
1565	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-05 00:52:33.191+07
1566	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-05 00:52:38.236+07
1567	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-06-05 00:52:42.801+07
1568	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-05 01:03:01.278+07
1569	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-05 01:08:04.824+07
1570	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-05 01:08:25.361+07
1571	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-05 01:08:25.755+07
1572	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-05 01:08:30.246+07
1573	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-05 01:08:46.411+07
1574	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-05 01:09:12.316+07
1575	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-05 01:09:17.526+07
1576	3	0	Aktivitas Login	Budiono sedang berada di halaman dashboard.	2014-06-05 01:12:39.126+07
1577	3	0	Aktivitas Logout	Budiono baru saja sgn out dari SI Task Management.	2014-06-05 01:12:48.357+07
1578	2	0	Aktivitas Login	Aris sedang berada di halaman dashboard.	2014-06-05 01:12:57.347+07
1579	2	0	Aktivitas Logout	Aris baru saja sgn out dari SI Task Management.	2014-06-05 01:13:00.349+07
1580	4	0	Aktivitas Login	Joko sedang berada di halaman dashboard.	2014-06-05 01:13:15.371+07
1581	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-05 01:13:32.847+07
1582	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-05 01:13:55.091+07
1583	4	0	Aktivitas Pekerjaan	Joko sedang melihat detail tentang pekerjaannya.	2014-06-05 01:14:14.588+07
1584	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-05 01:31:22.579+07
1585	4	0	Aktivitas Pekerjaan	Joko sedang melihat detail tentang pekerjaannya.	2014-06-05 01:31:31.551+07
1586	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-05 01:31:42.891+07
1587	4	0	Aktivitas Pekerjaan	Joko sedang melihat detail tentang pekerjaannya.	2014-06-05 01:36:15.633+07
1588	4	0	Aktivitas Pekerjaan	Joko sedang melihat detail tentang pekerjaannya.	2014-06-05 01:36:25.818+07
1589	4	0	Aktivitas Logout	Joko baru saja sgn out dari SI Task Management.	2014-06-05 01:37:00.458+07
1590	3	0	Aktivitas Pekerjaan	Budiono sedang melihat detail tentang pekerjaannya.	2014-06-05 01:37:17.95+07
1591	3	0	Aktivitas Pekerjaan	Budiono sedang melihat detail tentang pekerjaannya.	2014-06-05 01:37:27.583+07
1592	3	0	Aktivitas Pekerjaan	Budiono sedang berada di halaman pekerjaan.	2014-06-05 01:38:02.031+07
1593	3	0	Aktivitas Pekerjaan	Budiono baru saja mengusulkan pekerjaan.	2014-06-05 01:38:33.349+07
1594	3	0	Aktivitas Pekerjaan	Budiono sedang berada di halaman pekerjaan.	2014-06-05 01:38:33.6+07
1595	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-06-05 01:38:38.994+07
1596	12	0	Aktivitas Login	Tommy sedang berada di halaman dashboard.	2014-06-05 01:40:44.132+07
1597	12	0	Aktivitas Login	Tommy sedang berada di halaman dashboard.	2014-06-05 01:42:30.375+07
1598	12	0	Aktivitas Login	Tommy sedang berada di halaman dashboard.	2014-06-05 01:43:33.417+07
1599	12	0	Aktivitas Login	Tommy sedang berada di halaman dashboard.	2014-06-05 01:44:38.265+07
1600	12	0	Aktivitas Login	Tommy sedang berada di halaman dashboard.	2014-06-05 01:45:36.426+07
1601	12	0	Aktivitas Pekerjaan	Tommy sedang melihat detail tentang pekerjaannya.	2014-06-05 01:56:19.65+07
1602	12	0	Aktivitas Pekerjaan	Tommy sedang melihat detail tentang pekerjaannya.	2014-06-05 01:56:31.737+07
1603	3	0	Aktivitas Pekerjaan	Budiono sedang melihat detail tentang pekerjaannya.	2014-06-05 01:59:10.576+07
1604	12	0	Aktivitas Pekerjaan	Tommy baru saja melakukan perubahan pada detail pekerjaan.	2014-06-05 02:01:10.494+07
1605	12	0	Aktivitas Pekerjaan	Tommy sedang melihat detail tentang pekerjaannya.	2014-06-05 02:01:21.552+07
1627	12	0	Aktivitas Pekerjaan	Tommy sedang melihat detail tentang pekerjaannya.	2014-06-05 02:21:14.033+07
1628	12	0	Aktivitas Pekerjaan	Tommy baru saja melakukan perubahan pada detail pekerjaan.	2014-06-05 02:21:21.475+07
1630	12	0	Aktivitas Pekerjaan	Tommy sedang melihat detail tentang pekerjaannya.	2014-06-05 02:23:38.438+07
1631	12	0	Aktivitas Pekerjaan	Tommy baru saja melakukan perubahan pada detail pekerjaan.	2014-06-05 02:23:41.821+07
1632	12	0	Aktivitas Login	Tommy sedang berada di halaman dashboard.	2014-06-05 02:27:26.017+07
1606	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-05 02:01:26.919+07
1607	3	0	Aktivitas Pekerjaan	Budiono sedang melihat detail tentang pekerjaannya.	2014-06-05 02:01:46.079+07
1614	12	0	Aktivitas Pekerjaan	Tommy baru saja melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-06-05 02:08:08.384+07
1622	12	0	Aktivitas Pekerjaan	Tommy baru saja melakukan perubahan pada detail pekerjaan.	2014-06-05 02:16:07.748+07
1624	12	0	Aktivitas Pekerjaan	Tommy sedang melihat detail tentang pekerjaannya.	2014-06-05 02:17:21.098+07
1636	12	0	Aktivitas Pekerjaan	Tommy baru saja melakukan perubahan pada detail pekerjaan.	2014-06-05 02:29:36.233+07
1640	12	0	Aktivitas Pekerjaan	Tommy baru saja melakukan perubahan pada detail pekerjaan.	2014-06-05 02:31:51.088+07
1608	12	0	Aktivitas Pekerjaan	Tommy sedang melihat detail tentang pekerjaannya.	2014-06-05 02:02:09.561+07
1612	3	0	Aktivitas Pekerjaan	Budiono baru saja melakukan perubahan pada detail pekerjaan.	2014-06-05 02:06:29.662+07
1613	3	0	Aktivitas Pekerjaan	Budiono baru saja melakukan perubahan pada detail pekerjaan.	2014-06-05 02:07:52.391+07
1637	12	0	Aktivitas Pekerjaan	Tommy sedang melihat detail tentang pekerjaannya.	2014-06-05 02:29:56.754+07
1644	12	0	Aktivitas Pekerjaan	Tommy sedang melihat detail tentang pekerjaannya.	2014-06-05 02:38:07.532+07
1648	12	0	Aktivitas Pekerjaan	Tommy sedang melihat detail tentang pekerjaannya.	2014-06-05 02:42:07.058+07
1650	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-05 02:42:58.737+07
1651	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-06-05 02:43:15.137+07
1609	3	0	Aktivitas Pekerjaan	Budiono sedang melihat detail tentang pekerjaannya.	2014-06-05 02:02:16.436+07
1610	3	0	Aktivitas Pekerjaan	Budiono sedang melihat detail tentang pekerjaannya.	2014-06-05 02:05:08.646+07
1611	3	0	Aktivitas Pekerjaan	Budiono baru saja melakukan perubahan pada detail pekerjaan.	2014-06-05 02:05:13.904+07
1615	3	0	Aktivitas Pekerjaan	Budiono sedang melihat detail tentang pekerjaannya.	2014-06-05 02:08:21.111+07
1616	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-06-05 02:08:38.936+07
1617	1	0	Aktivitas Login	Dr. Bendrong sedang berada di halaman dashboard.	2014-06-05 02:08:43.15+07
1621	12	0	Aktivitas Pekerjaan	Tommy sedang melihat detail tentang pekerjaannya.	2014-06-05 02:15:37.288+07
1623	12	0	Aktivitas Pekerjaan	Tommy sedang melihat detail tentang pekerjaannya.	2014-06-05 02:16:25.975+07
1638	12	0	Aktivitas Pekerjaan	Tommy baru saja melakukan perubahan pada detail pekerjaan.	2014-06-05 02:31:18.406+07
1639	12	0	Aktivitas Pekerjaan	Tommy sedang melihat detail tentang pekerjaannya.	2014-06-05 02:31:33.802+07
1641	12	0	Aktivitas Pekerjaan	Tommy baru saja melakukan perubahan pada detail pekerjaan.	2014-06-05 02:37:09.959+07
1642	12	0	Aktivitas Pekerjaan	Tommy sedang melihat detail tentang pekerjaannya.	2014-06-05 02:37:42.227+07
1643	12	0	Aktivitas Pekerjaan	Tommy baru saja melakukan perubahan pada detail pekerjaan.	2014-06-05 02:37:52.999+07
1645	12	0	Aktivitas Pekerjaan	Tommy sedang melihat detail tentang pekerjaannya.	2014-06-05 02:39:02.979+07
1649	12	0	Aktivitas Login	Tommy sedang berada di halaman dashboard.	2014-06-05 02:42:43.91+07
1618	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat detail tentang pekerjaannya.	2014-06-05 02:09:36.262+07
1619	1	0	Aktivitas Pekerjaan	Dr. Bendrong baru saja melakukan perubahan pada detail pekerjaan.	2014-06-05 02:14:39.602+07
1620	12	0	Aktivitas Pekerjaan	Tommy sedang melihat detail tentang pekerjaannya.	2014-06-05 02:14:57.08+07
1625	1	0	Aktivitas Pekerjaan	Dr. Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-06-05 02:18:59.293+07
1626	12	0	Aktivitas Login	Tommy sedang berada di halaman dashboard.	2014-06-05 02:21:05.481+07
1629	12	0	Aktivitas Pekerjaan	Tommy sedang melihat progress pekerjaan dari para staffnya.	2014-06-05 02:22:39.534+07
1633	12	0	Aktivitas Pekerjaan	Tommy sedang melihat detail tentang pekerjaannya.	2014-06-05 02:27:33.178+07
1634	12	0	Aktivitas Pekerjaan	Tommy baru saja melakukan perubahan pada detail pekerjaan.	2014-06-05 02:27:39.787+07
1635	12	0	Aktivitas Pekerjaan	Tommy baru saja melakukan perubahan pada detail pekerjaan.	2014-06-05 02:28:37.704+07
1646	12	0	Aktivitas Pekerjaan	Tommy sedang melihat detail tentang pekerjaannya.	2014-06-05 02:39:12.929+07
1647	12	0	Aktivitas Pekerjaan	Tommy sedang melihat detail tentang pekerjaannya.	2014-06-05 02:39:21.642+07
1652	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-05 11:06:53.27+07
1653	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-05 11:08:16.679+07
1654	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-05 11:08:50.345+07
1655	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-05 11:09:00.476+07
1656	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja memberikan pekerjaan kepada staffnya.	2014-06-05 11:09:43.184+07
1657	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-05 11:09:43.532+07
1658	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-05 11:09:47.782+07
1659	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-05 11:12:35.663+07
1660	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-05 11:12:52.406+07
1661	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-05 11:13:41.368+07
1662	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-05 22:39:53.091+07
1663	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-05 22:40:00.249+07
1664	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-05 22:40:12.615+07
1665	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-05 22:40:21.454+07
1666	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-05 22:45:49.744+07
1667	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-05 22:47:16.179+07
1668	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-05 22:47:21.497+07
1669	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-05 22:47:24.475+07
1670	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-05 23:01:57.758+07
1671	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-05 23:08:33.003+07
1672	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-05 23:13:12.991+07
1673	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-05 23:22:23.93+07
1674	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-05 23:22:52.672+07
1675	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-05 23:23:43.544+07
1676	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-06 00:02:15.958+07
1677	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-06 00:16:39.918+07
1678	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-06 00:16:49.574+07
1679	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja memberikan pekerjaan kepada staffnya.	2014-06-06 00:17:34.505+07
1680	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-06 00:17:34.704+07
1681	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-06 00:17:38.494+07
1682	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-06 00:18:09.644+07
1683	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-06 00:20:11.131+07
1684	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-06 00:20:45.748+07
1685	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-06 00:21:22.448+07
1686	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-06 00:21:58.967+07
1687	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-06 00:23:18.203+07
1688	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-06 00:23:33.759+07
1689	7	0	Aktivitas Login	Didi Aryono Budiyono, dr, Sp.KJ(K) sedang berada di halaman dashboard.	2014-06-06 00:25:04.299+07
1690	7	0	Aktivitas Login	Didi Aryono Budiyono, dr, Sp.KJ(K) sedang berada di halaman dashboard.	2014-06-06 00:26:33.192+07
1691	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-06 00:28:17.184+07
1692	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-06 00:37:05.851+07
1693	7	0	Aktivitas Pekerjaan	Didi Aryono Budiyono, dr, Sp.KJ(K) sedang melihat detail tentang pekerjaannya.	2014-06-06 00:37:12.237+07
1694	7	0	Aktivitas Pekerjaan	Didi Aryono Budiyono, dr, Sp.KJ(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 00:48:49.434+07
1695	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 00:48:57.514+07
1696	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 00:50:44.364+07
1697	7	0	Aktivitas Pekerjaan	Didi Aryono Budiyono, dr, Sp.KJ(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 00:50:49.729+07
1698	7	0	Aktivitas Pekerjaan	Didi Aryono Budiyono, dr, Sp.KJ(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 00:52:34.449+07
1699	7	0	Aktivitas Pekerjaan	Didi Aryono Budiyono, dr, Sp.KJ(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 00:53:15.761+07
1700	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 00:54:13.313+07
1701	7	0	Aktivitas Login	Didi Aryono Budiyono, dr, Sp.KJ(K) sedang berada di halaman dashboard.	2014-06-06 00:56:25.954+07
1702	7	0	Aktivitas Pekerjaan	Didi Aryono Budiyono, dr, Sp.KJ(K) sedang melihat detail tentang pekerjaannya.	2014-06-06 00:56:31.247+07
1703	7	0	Aktivitas Pekerjaan	Didi Aryono Budiyono, dr, Sp.KJ(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 00:56:33.97+07
1704	7	0	Aktivitas Pekerjaan	Didi Aryono Budiyono, dr, Sp.KJ(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 00:58:19.159+07
1774	8	0	Aktivitas Login	Tutik Murniati, SE sedang berada di halaman dashboard.	2014-06-06 02:38:54.688+07
1705	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 01:02:06.473+07
1710	7	0	Aktivitas Pekerjaan	Didi Aryono Budiyono, dr, Sp.KJ(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 01:11:41.686+07
1731	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-06 01:38:51.166+07
1732	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 01:39:56.886+07
1733	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-06 01:40:04.374+07
1734	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-06 01:41:39.537+07
1735	10	0	Aktivitas Pekerjaan	Widyowati baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 01:42:05.535+07
1741	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-06 01:48:12.073+07
1742	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-06 01:48:44.639+07
1748	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-06 01:51:43.983+07
1749	10	0	Aktivitas Pekerjaan	Widyowati sedang berada di halaman pekerjaan.	2014-06-06 01:51:50.931+07
1758	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-06 01:56:16.804+07
1759	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-06 02:04:28.317+07
1760	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-06 02:05:33.966+07
1761	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-06 02:07:49.726+07
1763	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-06 02:32:27.644+07
1764	10	0	Aktivitas Pekerjaan	Widyowati sedang berada di halaman pekerjaan.	2014-06-06 02:33:24.106+07
1765	10	0	Aktivitas Pekerjaan	Widyowati baru saja mengusulkan pekerjaan.	2014-06-06 02:36:03.437+07
1766	10	0	Aktivitas Pekerjaan	Widyowati sedang berada di halaman pekerjaan.	2014-06-06 02:36:03.756+07
1767	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat daftar usulan pekerjaan yang ada.	2014-06-06 02:36:19.95+07
1768	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-06 02:36:27.152+07
1769	6	0	Aktivitas Logout	Sunarso Suyoso, dr, Sp.KK(K) baru saja sgn out dari SI Task Management.	2014-06-06 02:37:36.632+07
1798	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-06 02:51:37.489+07
1799	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-06-06 02:52:06.246+07
1800	10	0	Aktivitas Pekerjaan	Widyowati sedang berada di halaman pekerjaan.	2014-06-06 02:52:30.747+07
1801	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-06 02:52:48.791+07
1802	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-06 02:53:11.275+07
1832	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-06 03:41:45.726+07
1833	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-06 03:41:54.311+07
1706	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 01:03:22.131+07
1711	7	0	Aktivitas Pekerjaan	Didi Aryono Budiyono, dr, Sp.KJ(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 01:12:57.874+07
1716	7	0	Aktivitas Pekerjaan	Didi Aryono Budiyono, dr, Sp.KJ(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 01:15:13.58+07
1717	7	0	Aktivitas Pekerjaan	Didi Aryono Budiyono, dr, Sp.KJ(K) sedang melihat detail tentang pekerjaannya.	2014-06-06 01:22:26.874+07
1718	7	0	Aktivitas Logout	Didi Aryono Budiyono, dr, Sp.KJ(K) baru saja sgn out dari SI Task Management.	2014-06-06 01:25:06.439+07
1719	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-06 01:25:14.161+07
1724	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-06 01:27:43.887+07
1726	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-06 01:29:24.661+07
1727	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-06 01:30:51.752+07
1728	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-06 01:33:23.581+07
1729	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-06 01:35:17.107+07
1730	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-06 01:35:26.234+07
1736	10	0	Aktivitas Pekerjaan	Widyowati baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 01:43:35.228+07
1737	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-06 01:45:18.386+07
1738	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-06 01:45:29.025+07
1739	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja memberikan pekerjaan kepada staffnya.	2014-06-06 01:46:23.031+07
1740	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-06 01:46:23.246+07
1745	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-06 01:50:39.893+07
1746	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-06 01:50:45.474+07
1747	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-06 01:51:19.195+07
1752	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-06 01:52:37.909+07
1756	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat daftar usulan pekerjaan yang ada.	2014-06-06 01:55:45.488+07
1757	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-06 01:55:53.863+07
1770	8	0	Aktivitas Login	Tutik Murniati, SE sedang berada di halaman dashboard.	2014-06-06 02:37:58.033+07
1771	8	0	Aktivitas Pekerjaan	Tutik Murniati, SE sedang melihat detail tentang pekerjaannya.	2014-06-06 02:38:17.092+07
1772	8	0	Aktivitas Login	Tutik Murniati, SE sedang berada di halaman dashboard.	2014-06-06 02:38:23.538+07
1773	8	0	Aktivitas Pekerjaan	Tutik Murniati, SE sedang melihat detail tentang pekerjaannya.	2014-06-06 02:38:31.51+07
1707	7	0	Aktivitas Pekerjaan	Didi Aryono Budiyono, dr, Sp.KJ(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 01:06:21.763+07
1708	7	0	Aktivitas Pekerjaan	Didi Aryono Budiyono, dr, Sp.KJ(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 01:07:44.658+07
1709	7	0	Aktivitas Pekerjaan	Didi Aryono Budiyono, dr, Sp.KJ(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 01:10:02.357+07
1712	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 01:13:49.949+07
1713	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-06 01:14:11.881+07
1714	7	0	Aktivitas Pekerjaan	Didi Aryono Budiyono, dr, Sp.KJ(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 01:14:24.296+07
1715	7	0	Aktivitas Pekerjaan	Didi Aryono Budiyono, dr, Sp.KJ(K) sedang melihat detail tentang pekerjaannya.	2014-06-06 01:14:41.922+07
1720	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-06 01:25:42.407+07
1721	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-06 01:25:53.149+07
1722	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-06 01:26:05.237+07
1723	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-06 01:27:20.952+07
1725	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-06 01:29:14.858+07
1743	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-06 01:50:22.792+07
1744	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 01:50:29.741+07
1750	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 01:52:19.968+07
1751	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-06 01:52:32.992+07
1753	10	0	Aktivitas Pekerjaan	Widyowati sedang berada di halaman pekerjaan.	2014-06-06 01:52:48.097+07
1754	10	0	Aktivitas Pekerjaan	Widyowati sedang berada di halaman pekerjaan.	2014-06-06 01:55:06.959+07
1755	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-06 01:55:13.402+07
1762	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-06 02:32:13.872+07
1777	8	0	Aktivitas Logout	Tutik Murniati, SE baru saja sgn out dari SI Task Management.	2014-06-06 02:40:25.12+07
1778	10	0	Aktivitas Pekerjaan	Widyowati baru saja mengusulkan pekerjaan.	2014-06-06 02:40:52.173+07
1779	10	0	Aktivitas Pekerjaan	Widyowati sedang berada di halaman pekerjaan.	2014-06-06 02:40:53.999+07
1780	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-06 02:41:04.125+07
1781	10	0	Aktivitas Pekerjaan	Widyowati baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 02:41:12.059+07
1782	10	0	Aktivitas Pekerjaan	Widyowati sedang berada di halaman pekerjaan.	2014-06-06 02:42:22.122+07
1783	10	0	Aktivitas Pekerjaan	Widyowati sedang berada di halaman pekerjaan.	2014-06-06 02:43:30.01+07
1784	10	0	Aktivitas Pekerjaan	Widyowati baru saja mengusulkan pekerjaan.	2014-06-06 02:44:25.538+07
1785	10	0	Aktivitas Pekerjaan	Widyowati sedang berada di halaman pekerjaan.	2014-06-06 02:44:25.905+07
1786	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-06 02:44:58.477+07
1787	10	0	Aktivitas Pekerjaan	Widyowati baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 02:45:03.179+07
1788	10	0	Aktivitas Pekerjaan	Widyowati sedang berada di halaman pekerjaan.	2014-06-06 02:48:07.523+07
1789	10	0	Aktivitas Pekerjaan	Widyowati sedang berada di halaman pekerjaan.	2014-06-06 02:48:50.824+07
1790	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-06 02:49:03.442+07
1791	10	0	Aktivitas Pekerjaan	Widyowati baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 02:49:22.007+07
1792	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-06 02:49:54.803+07
1803	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-06 02:54:51.659+07
1804	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-06 02:57:21+07
1805	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-06 02:57:31.671+07
1812	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-06 03:03:14.345+07
1814	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-06 03:03:39.839+07
1815	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja mengusulkan pekerjaan.	2014-06-06 03:04:09.798+07
1816	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-06 03:04:10.241+07
1825	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 03:13:45.172+07
1826	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 03:14:58.874+07
1830	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-06 03:19:37.447+07
1831	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-06 03:20:06.676+07
1775	8	0	Aktivitas Pekerjaan	Tutik Murniati, SE sedang melihat detail tentang pekerjaannya.	2014-06-06 02:39:05.433+07
1776	8	0	Aktivitas Login	Tutik Murniati, SE sedang berada di halaman dashboard.	2014-06-06 02:39:44.017+07
1793	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-06 02:50:15.474+07
1794	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-06 02:50:29.63+07
1795	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-06 02:50:42.868+07
1807	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-06 02:59:32.403+07
1808	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-06 02:59:45.591+07
1809	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-06 02:59:59.125+07
1810	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-06 03:02:38.152+07
1811	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-06 03:02:45.295+07
1813	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-06 03:03:26.42+07
1820	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja membuat draft pekerjaan.	2014-06-06 03:07:37.155+07
1796	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 02:51:06.593+07
1797	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-06 02:51:27.412+07
1806	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-06 02:58:18.489+07
1834	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 03:41:58.102+07
1835	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja membuat draft pekerjaan.	2014-06-06 03:43:05.306+07
1817	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-06 03:04:33.038+07
1818	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-06 03:06:29.371+07
1819	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-06 03:06:39.721+07
1821	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-06 03:07:43.522+07
1822	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-06 03:07:54.565+07
1823	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 03:08:00.875+07
1824	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 03:12:53.286+07
1827	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 03:16:08.352+07
1828	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 03:16:12.478+07
1829	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 03:16:41.863+07
1836	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-06 09:04:00.433+07
1837	12	0	Aktivitas Login	Rama Khrisna, SKM,M.Pd sedang berada di halaman dashboard.	2014-06-06 09:11:31.199+07
1838	12	0	Aktivitas Pekerjaan	Rama Khrisna, SKM,M.Pd sedang melihat daftar usulan pekerjaan yang ada.	2014-06-06 09:12:17.865+07
1839	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-06 09:26:01.45+07
1840	12	0	Aktivitas Logout	Rama Khrisna, SKM,M.Pd baru saja sgn out dari SI Task Management.	2014-06-06 09:29:57.64+07
1841	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-06 09:30:07.739+07
1842	6	0	Aktivitas Logout	Sunarso Suyoso, dr, Sp.KK(K) baru saja sgn out dari SI Task Management.	2014-06-06 09:33:34.365+07
1843	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2014-06-06 09:33:43.241+07
1844	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat daftar usulan pekerjaan yang ada.	2014-06-06 09:33:51.666+07
1845	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2014-06-06 09:33:54.627+07
1846	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2014-06-06 10:14:03.213+07
1847	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-06 10:14:19.179+07
1848	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2014-06-06 10:14:28.16+07
1849	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2014-06-06 10:23:10.215+07
1850	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2014-06-06 10:23:22.323+07
1851	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja melakukan perubahan pada detail pekerjaan.	2014-06-06 10:23:26.852+07
1852	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2014-06-06 10:23:39.226+07
1853	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2014-06-06 10:23:57.131+07
1854	1	0	Aktivitas Logout	dr. Dodo Anondo, MPH baru saja sgn out dari SI Task Management.	2014-06-06 10:24:04.862+07
1855	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-06 10:24:13.975+07
1856	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-06 10:24:58.269+07
1857	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-06 10:27:13.659+07
1858	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-06 10:44:18.376+07
1859	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-11 21:32:02.661+07
1860	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-11 21:44:44.185+07
1861	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-11 21:44:57.989+07
1862	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-11 21:45:03.794+07
1863	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-11 21:45:41.233+07
1864	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-11 21:48:01.037+07
1865	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat daftar usulan pekerjaan yang ada.	2014-06-11 21:48:04.093+07
1866	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-11 21:48:06.889+07
1867	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-11 21:48:09.805+07
1868	12	0	Aktivitas Login	Rama Khrisna, SKM,M.Pd sedang berada di halaman dashboard.	2014-06-11 21:48:40.663+07
1869	12	0	Aktivitas Login	Rama Khrisna, SKM,M.Pd sedang berada di halaman dashboard.	2014-06-11 21:48:43.497+07
1870	12	0	Aktivitas Pekerjaan	Rama Khrisna, SKM,M.Pd sedang berada di halaman pekerjaan.	2014-06-11 21:49:11.188+07
1871	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-11 21:50:07.217+07
1872	12	0	Aktivitas Pekerjaan	Rama Khrisna, SKM,M.Pd sedang berada di halaman pekerjaan.	2014-06-11 22:06:32.471+07
1873	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-11 22:06:51.49+07
1874	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-11 22:07:04.613+07
1875	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-11 22:56:04.233+07
1876	6	0	Aktivitas Komentar	Sunarso Suyoso, dr, Sp.KK(K) baru saja memberikan komentar : hay	2014-06-11 22:56:15.153+07
1877	6	0	Aktivitas Komentar	Sunarso Suyoso, dr, Sp.KK(K) baru saja memberikan komentar : yo	2014-06-11 22:56:26.438+07
1878	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-13 21:06:11.394+07
1879	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-13 21:07:36.796+07
1880	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-13 21:29:10.547+07
1881	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-13 21:29:53.404+07
1882	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-13 21:35:16.226+07
1883	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-13 21:36:27.624+07
1884	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-13 21:37:19.303+07
1885	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-13 21:37:34.539+07
1886	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat daftar usulan pekerjaan yang ada.	2014-06-13 21:37:42.852+07
1887	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-13 21:37:53.534+07
1888	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-13 23:06:44.396+07
1889	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-13 23:06:56.073+07
1890	6	0	Aktivitas Logout	Sunarso Suyoso, dr, Sp.KK(K) baru saja sgn out dari SI Task Management.	2014-06-13 23:15:02.948+07
1892	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat laporan pekerjaan dari para staffnya.	2014-06-13 23:15:34.297+07
1899	20	0	Aktivitas Pekerjaan	dr Bendrong sedang melihat laporan pekerjaan dari para staffnya.	2014-06-13 23:22:11.148+07
1901	20	0	Aktivitas Pekerjaan	dr Bendrong sedang berada di halaman pekerjaan.	2014-06-13 23:27:49.062+07
1891	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-13 23:15:22.194+07
1893	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat laporan pekerjaan dari para staffnya.	2014-06-13 23:16:50.569+07
1894	6	0	Aktivitas Logout	Sunarso Suyoso, dr, Sp.KK(K) baru saja sgn out dari SI Task Management.	2014-06-13 23:18:16.503+07
1895	20	0	Aktivitas Login	dr Bendrong sedang berada di halaman dashboard.	2014-06-13 23:19:33.328+07
1896	20	0	Aktivitas Pekerjaan	dr Bendrong sedang melihat laporan pekerjaan dari para staffnya.	2014-06-13 23:19:40.142+07
2012	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 21:19:06.091+07
1897	20	0	Aktivitas Pekerjaan	dr Bendrong sedang melihat laporan pekerjaan dari para staffnya.	2014-06-13 23:20:23.352+07
1898	20	0	Aktivitas Pekerjaan	dr Bendrong sedang melihat laporan pekerjaan dari para staffnya.	2014-06-13 23:20:50.506+07
1900	20	0	Aktivitas Pekerjaan	dr Bendrong sedang melihat laporan pekerjaan dari para staffnya.	2014-06-13 23:22:22.333+07
1902	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 09:04:09.617+07
1903	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-14 09:10:35.588+07
1904	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-14 09:11:41.731+07
1905	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-14 09:12:48.008+07
1906	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 09:12:54.034+07
1907	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 09:14:01.225+07
1908	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 09:15:28.232+07
1909	6	0	Aktivitas Komentar	Sunarso Suyoso, dr, Sp.KK(K) baru saja memberikan komentar : hmmm	2014-06-14 09:15:42.637+07
1910	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 09:15:47.332+07
1911	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 09:16:16.463+07
1912	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 09:17:23.238+07
1913	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 09:17:42.222+07
1914	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 09:19:21.213+07
1915	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 09:23:10.074+07
1916	6	0	Aktivitas Komentar	Sunarso Suyoso, dr, Sp.KK(K) baru saja memberikan komentar : tes	2014-06-14 09:23:27.112+07
1917	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 09:24:44.385+07
1918	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 09:26:03.231+07
1919	6	0	Aktivitas Komentar	Sunarso Suyoso, dr, Sp.KK(K) baru saja memberikan komentar : tes komentar	2014-06-14 09:26:16.253+07
1920	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 09:27:10.388+07
1921	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 09:27:33.631+07
1922	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 09:34:35.127+07
1923	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 09:37:35.471+07
1924	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 09:37:52.516+07
1925	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 09:40:06.2+07
1926	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 09:40:33.012+07
1927	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-14 09:40:48.922+07
1928	6	0	Aktivitas Logout	Sunarso Suyoso, dr, Sp.KK(K) baru saja sgn out dari SI Task Management.	2014-06-14 09:42:34.4+07
1929	20	0	Aktivitas Login	dr Bendrong sedang berada di halaman dashboard.	2014-06-14 09:43:31.59+07
1930	20	0	Aktivitas Login	dr Bendrong sedang berada di halaman dashboard.	2014-06-14 09:44:42.989+07
1931	20	0	Aktivitas Login	dr Bendrong sedang berada di halaman dashboard.	2014-06-14 09:45:06.384+07
1932	20	0	Aktivitas Login	dr Bendrong sedang berada di halaman dashboard.	2014-06-14 09:53:46.068+07
1933	20	0	Aktivitas Pekerjaan	dr Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-06-14 09:55:44.006+07
1934	20	0	Aktivitas Pekerjaan	dr Bendrong sedang melihat daftar usulan pekerjaan yang ada.	2014-06-14 09:57:11.444+07
1935	20	0	Aktivitas Pekerjaan	dr Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-06-14 09:57:19.681+07
1936	20	0	Aktivitas Pekerjaan	dr Bendrong sedang berada di halaman pekerjaan.	2014-06-14 10:09:09.819+07
1937	20	0	Aktivitas Pekerjaan	dr Bendrong sedang melihat progress pekerjaan dari para staffnya.	2014-06-14 10:11:22.02+07
1938	20	0	Aktivitas Logout	dr Bendrong baru saja sgn out dari SI Task Management.	2014-06-14 10:15:02.223+07
1939	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 10:15:12.39+07
1940	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 10:15:32.207+07
1941	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 10:15:40.348+07
1942	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-14 10:22:50.209+07
1943	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 10:23:17.017+07
1944	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-14 10:24:53.47+07
1945	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 10:25:08.332+07
1946	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 10:38:37.814+07
1947	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 10:45:37.017+07
1948	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 10:46:23.865+07
1949	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 13:33:31.544+07
1950	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-14 13:35:33.357+07
1951	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 13:41:20.716+07
1952	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 13:42:26.582+07
1953	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 13:45:17.115+07
1954	6	0	Aktivitas Komentar	Sunarso Suyoso, dr, Sp.KK(K) baru saja memberikan komentar : kok gag di accept2 ya	2014-06-14 13:45:58.372+07
1955	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 13:49:34.548+07
1956	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 13:53:25.609+07
1957	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 13:53:25.684+07
1958	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 13:55:12.55+07
1959	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 13:55:28.531+07
1960	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 13:56:02.774+07
1961	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 13:57:28.145+07
1962	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-14 13:57:40.63+07
1963	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-14 14:00:00.818+07
1964	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 14:12:08.066+07
1965	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-06-14 14:16:56.714+07
1966	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-14 14:18:47.646+07
1967	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 14:19:00.256+07
1974	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 14:37:02.197+07
1976	6	0	Aktivitas Komentar	Sunarso Suyoso, dr, Sp.KK(K) baru saja memberikan komentar : mohon segera di acc pak	2014-06-14 14:37:46.635+07
1977	6	0	Aktivitas Logout	Sunarso Suyoso, dr, Sp.KK(K) baru saja sgn out dari SI Task Management.	2014-06-14 14:37:52.809+07
1978	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2014-06-14 14:38:49.506+07
1982	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-14 14:40:07.106+07
1983	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja mengusulkan pekerjaan.	2014-06-14 14:40:52.874+07
1984	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-14 14:40:53.145+07
1985	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 14:41:04.177+07
1986	6	0	Aktivitas Logout	Sunarso Suyoso, dr, Sp.KK(K) baru saja sgn out dari SI Task Management.	2014-06-14 14:41:11.464+07
1987	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2014-06-14 14:41:25.677+07
1990	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-06-14 14:42:07.754+07
1991	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2014-06-14 14:42:21.965+07
1992	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2014-06-14 14:48:38.657+07
1993	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2014-06-14 14:51:02.873+07
1994	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2014-06-14 14:55:58.609+07
1995	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2014-06-14 14:55:58.708+07
1968	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-14 14:19:40.308+07
1969	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-14 14:24:36.843+07
1970	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 14:25:34.921+07
1971	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-14 14:26:31.047+07
1972	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja mengusulkan pekerjaan.	2014-06-14 14:36:40.831+07
1973	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-14 14:36:41.067+07
1975	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 14:37:32.243+07
1979	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2014-06-14 14:39:04.378+07
1980	1	0	Aktivitas Logout	dr. Dodo Anondo, MPH baru saja sgn out dari SI Task Management.	2014-06-14 14:39:20.367+07
1981	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 14:39:58.735+07
1988	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2014-06-14 14:41:36.25+07
1989	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat daftar usulan pekerjaan yang ada.	2014-06-14 14:41:47.603+07
1996	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja melakukan perubahan pada detail pekerjaan.	2014-06-14 14:56:06.484+07
1997	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 20:48:06.889+07
1998	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat laporan pekerjaan dari para staffnya.	2014-06-14 20:49:52.326+07
1999	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-14 20:51:08.057+07
2000	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 20:53:59.669+07
2001	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 20:54:28.359+07
2002	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 20:54:36.708+07
2003	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 20:54:41.841+07
2004	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-14 20:54:44.506+07
2005	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-14 20:54:55.263+07
2006	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 20:55:06.815+07
2007	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-14 20:55:10.883+07
2008	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 20:55:35.462+07
2009	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 21:13:43.315+07
2010	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 21:15:00.025+07
2011	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 21:15:33.452+07
2013	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 21:20:44.737+07
2014	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 21:21:16.201+07
2015	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 21:22:19.46+07
2016	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 21:22:32.741+07
2017	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 21:22:54.509+07
2018	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 21:23:50.413+07
2019	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-14 21:24:03.741+07
2020	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-14 21:27:31.923+07
2021	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 21:28:21.672+07
2022	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 21:30:07.034+07
2023	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 21:30:27.178+07
2024	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 21:34:07.167+07
2025	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 21:34:52.338+07
2026	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 21:38:45.713+07
2027	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 21:39:09.546+07
2028	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 21:39:42.643+07
2029	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 21:41:18.419+07
2030	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-14 21:43:56.95+07
2031	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 21:44:03.763+07
2032	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 21:44:16.213+07
2033	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 21:44:33.146+07
2034	10	0	Aktivitas Pekerjaan	Widyowati sedang berada di halaman pekerjaan.	2014-06-14 21:45:04.674+07
2035	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 21:45:11.154+07
2036	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 21:45:19.198+07
2037	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 21:45:26.922+07
2038	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 21:46:00.06+07
2039	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 21:46:11.816+07
2040	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 21:46:20.132+07
2041	10	0	Aktivitas Logout	Widyowati baru saja sgn out dari SI Task Management.	2014-06-14 21:46:39.604+07
2042	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-14 21:47:30.636+07
2043	10	0	Aktivitas Pekerjaan	Widyowati sedang berada di halaman pekerjaan.	2014-06-14 21:47:41.177+07
2044	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 21:48:24.927+07
2046	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 21:49:12.795+07
2049	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-14 22:01:21.008+07
2056	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-14 22:03:09.097+07
2067	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 22:21:04.564+07
2068	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 22:21:30.639+07
2086	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-14 22:33:16.153+07
2087	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 22:33:36.541+07
2088	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-14 22:33:47.044+07
2089	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 22:34:52.174+07
2096	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 22:42:48.387+07
2111	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 23:31:48.621+07
2117	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 23:54:56.666+07
2130	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 00:51:42.633+07
2131	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 00:52:18.749+07
2134	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-15 00:54:05.142+07
2135	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 00:54:12.198+07
2138	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 01:00:09.823+07
2140	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 01:01:47.636+07
2141	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 01:01:54.343+07
2045	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 21:48:35.994+07
2051	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat daftar usulan pekerjaan yang ada.	2014-06-14 22:02:23.857+07
2057	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-14 22:12:00.935+07
2059	10	0	Aktivitas Pekerjaan	Widyowati sedang berada di halaman pekerjaan.	2014-06-14 22:15:57.109+07
2065	10	0	Aktivitas Pekerjaan	Widyowati sedang berada di halaman pekerjaan.	2014-06-14 22:20:26.708+07
2066	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-14 22:20:53.686+07
2069	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 22:21:37.524+07
2070	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 22:21:46.007+07
2076	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-14 22:25:02.701+07
2078	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 22:25:38.708+07
2080	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 22:28:42.357+07
2082	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 22:28:57.772+07
2083	10	0	Aktivitas Pekerjaan	Widyowati sedang berada di halaman pekerjaan.	2014-06-14 22:29:11.421+07
2085	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 22:30:03.743+07
2097	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 22:43:20.804+07
2102	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 23:00:03.303+07
2047	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 21:50:52.092+07
2058	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 22:12:13.315+07
2071	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 22:22:16.597+07
2072	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 22:22:45.558+07
2091	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 22:40:42.663+07
2092	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 22:41:07.349+07
2094	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 22:41:47.553+07
2095	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 22:42:25.872+07
2110	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 23:29:42.029+07
2114	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 23:45:24.883+07
2119	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-15 00:02:06.658+07
2120	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-15 00:02:13.224+07
2121	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-15 00:02:24.753+07
2122	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-15 00:03:54.883+07
2123	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-15 00:04:57.356+07
2124	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-15 00:10:14.371+07
2125	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-15 00:15:14.749+07
2126	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-15 00:44:16.55+07
2127	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-15 00:47:19.438+07
2128	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-15 00:50:08.217+07
2129	10	0	Aktivitas Logout	Widyowati baru saja sgn out dari SI Task Management.	2014-06-15 00:51:24.413+07
2048	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 21:51:12.224+07
2052	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-14 22:02:29.049+07
2053	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 22:02:43.304+07
2054	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-14 22:02:47.272+07
2063	10	0	Aktivitas Pekerjaan	Widyowati sedang berada di halaman pekerjaan.	2014-06-14 22:19:36.491+07
2073	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 22:22:56.672+07
2074	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 22:23:44.945+07
2075	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-14 22:24:37.125+07
2079	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-14 22:26:36.386+07
2103	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 23:00:21.986+07
2105	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 23:15:06.906+07
2108	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 23:17:18.756+07
2109	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 23:27:40.678+07
2050	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-14 22:02:11.581+07
2055	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 22:02:58.861+07
2060	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 22:16:10.909+07
2061	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 22:16:21.882+07
2062	10	0	Aktivitas Pekerjaan	Widyowati sedang berada di halaman pekerjaan.	2014-06-14 22:19:26.456+07
2064	10	0	Aktivitas Pekerjaan	Widyowati sedang berada di halaman pekerjaan.	2014-06-14 22:20:15.34+07
2077	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-14 22:25:28.221+07
2101	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 22:53:23.386+07
2112	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 23:44:33.554+07
2113	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 23:45:03.971+07
2115	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 23:51:31.398+07
2116	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 23:54:11.843+07
2139	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-15 01:01:28.733+07
2081	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-14 22:28:47.771+07
2084	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 22:29:16.355+07
2090	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 22:40:06.28+07
2093	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 22:41:25.148+07
2098	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 22:43:46.385+07
2099	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 22:44:08.937+07
2100	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-14 22:49:19.212+07
2104	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 23:03:39.65+07
2106	10	0	Aktivitas Logout	Widyowati baru saja sgn out dari SI Task Management.	2014-06-14 23:16:55.226+07
2107	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-14 23:17:11.534+07
2118	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-14 23:56:20.852+07
2132	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 00:53:42.21+07
2133	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 00:53:58.829+07
2136	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 00:55:51.414+07
2137	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 00:59:27.893+07
2142	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 06:57:37.256+07
2143	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-15 06:58:10.933+07
2144	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 07:01:37.672+07
2145	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-15 07:02:59.986+07
2146	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 07:21:25.002+07
2147	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 07:46:08.564+07
2148	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 07:46:16.516+07
2149	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-15 07:46:27.017+07
2150	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 13:16:01.538+07
2151	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-15 13:18:50.056+07
2152	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-15 14:13:35.917+07
2153	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-15 14:20:39.13+07
2154	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-15 14:21:37.988+07
2155	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-15 14:23:04.813+07
2156	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 14:24:33.818+07
2157	6	0	Aktivitas Logout	Sunarso Suyoso, dr, Sp.KK(K) baru saja sgn out dari SI Task Management.	2014-06-15 14:33:37.843+07
2158	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-15 14:33:48.013+07
2159	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-15 14:33:55.734+07
2160	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-15 14:34:13.663+07
2161	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-15 14:34:24.28+07
2162	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-15 14:34:35.532+07
2163	10	0	Aktivitas Logout	Widyowati baru saja sgn out dari SI Task Management.	2014-06-15 14:34:39.604+07
2164	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 14:34:46.956+07
2165	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-15 14:34:55.383+07
2166	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 14:35:47.875+07
2167	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-15 14:35:51.303+07
2168	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 14:36:00.938+07
2169	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-15 14:36:09.408+07
2170	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 14:36:24.953+07
2171	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-15 14:36:28.638+07
2172	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 14:36:38.05+07
2173	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-15 14:36:53.82+07
2174	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 14:37:02.854+07
2175	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-15 14:37:12.185+07
2176	6	0	Aktivitas Logout	Sunarso Suyoso, dr, Sp.KK(K) baru saja sgn out dari SI Task Management.	2014-06-15 14:44:51.224+07
2177	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 14:44:59.132+07
2178	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 14:45:17.92+07
2179	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 14:45:24.613+07
2180	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 14:45:33.734+07
2181	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-15 14:46:37.758+07
2182	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 14:50:35.777+07
2183	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 14:51:23.4+07
2184	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 14:51:39.315+07
2189	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 14:52:57.986+07
2191	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 15:40:02.956+07
2193	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 16:55:47.019+07
2196	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 17:11:17.871+07
2203	6	0	Aktivitas Logout	Sunarso Suyoso, dr, Sp.KK(K) baru saja sgn out dari SI Task Management.	2014-06-15 17:25:02.069+07
2185	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 14:51:58.287+07
2187	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 14:52:31.012+07
2190	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 14:53:02.754+07
2194	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 17:06:05.744+07
2200	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-15 17:21:47.601+07
2201	6	0	Aktivitas Logout	Sunarso Suyoso, dr, Sp.KK(K) baru saja sgn out dari SI Task Management.	2014-06-15 17:22:54.482+07
2202	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 17:23:11.216+07
2186	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 14:52:22.979+07
2188	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 14:52:44.661+07
2192	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 15:57:41.797+07
2195	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 17:11:01.27+07
2197	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 17:13:36.61+07
2198	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 17:21:01.619+07
2199	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 17:21:36.622+07
2204	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 17:48:31.975+07
2206	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 19:36:09.056+07
2205	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 19:36:08.902+07
2207	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 22:35:29.405+07
2208	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 22:54:02.724+07
2209	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-15 23:00:39.717+07
2210	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 23:01:14.264+07
2211	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 23:02:55.596+07
2212	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 23:04:11.632+07
2213	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 23:05:17.548+07
2214	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-15 23:09:29.957+07
2215	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja memberikan pekerjaan kepada staffnya.	2014-06-15 23:10:07.618+07
2216	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja memberikan pekerjaan kepada staffnya.	2014-06-15 23:18:13.423+07
2217	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-15 23:18:13.597+07
2218	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 23:18:33.72+07
2219	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 23:18:45.206+07
2220	10	0	Aktivitas Logout	Widyowati baru saja sgn out dari SI Task Management.	2014-06-15 23:22:22.371+07
2221	8	0	Aktivitas Login	Tutik Murniati, SE sedang berada di halaman dashboard.	2014-06-15 23:22:33.781+07
2222	8	0	Aktivitas Pekerjaan	Tutik Murniati, SE sedang melihat detail tentang pekerjaannya.	2014-06-15 23:22:40.463+07
2223	8	0	Aktivitas Pekerjaan	Tutik Murniati, SE sedang melihat detail tentang pekerjaannya.	2014-06-15 23:22:48.37+07
2224	8	0	Aktivitas Pekerjaan	Tutik Murniati, SE sedang melihat detail tentang pekerjaannya.	2014-06-15 23:23:01.465+07
2225	8	0	Aktivitas Pekerjaan	Tutik Murniati, SE sedang melihat detail tentang pekerjaannya.	2014-06-15 23:23:51.329+07
2226	8	0	Aktivitas Login	Tutik Murniati, SE sedang berada di halaman dashboard.	2014-06-15 23:24:46.519+07
2227	8	0	Aktivitas Pekerjaan	Tutik Murniati, SE sedang melihat detail tentang pekerjaannya.	2014-06-15 23:25:00.634+07
2228	8	0	Aktivitas Pekerjaan	Tutik Murniati, SE sedang melihat detail tentang pekerjaannya.	2014-06-15 23:25:25.98+07
2229	8	0	Aktivitas Pekerjaan	Tutik Murniati, SE sedang melihat detail tentang pekerjaannya.	2014-06-15 23:25:37.678+07
2230	8	0	Aktivitas Pekerjaan	Tutik Murniati, SE sedang melihat detail tentang pekerjaannya.	2014-06-15 23:26:04.343+07
2231	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 23:27:25.55+07
2232	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 23:32:41.427+07
2233	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 23:33:05.669+07
2234	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-15 23:33:13.561+07
2235	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-15 23:33:39.123+07
2236	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 23:34:45.917+07
2237	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 23:36:32.717+07
2238	8	0	Aktivitas Pekerjaan	Tutik Murniati, SE sedang berada di halaman pekerjaan.	2014-06-15 23:38:42.246+07
2239	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 23:38:57.102+07
2240	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-15 23:39:15.498+07
2241	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 23:39:35.323+07
2242	8	0	Aktivitas Pekerjaan	Tutik Murniati, SE sedang berada di halaman pekerjaan.	2014-06-15 23:40:57.381+07
2243	8	0	Aktivitas Pekerjaan	Tutik Murniati, SE sedang berada di halaman pekerjaan.	2014-06-15 23:42:11.814+07
2244	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 23:42:17.686+07
2245	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-15 23:44:40.851+07
2246	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-15 23:44:50.768+07
2247	10	0	Aktivitas Pekerjaan	Widyowati sedang berada di halaman pekerjaan.	2014-06-15 23:45:01.046+07
2248	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-15 23:46:22.289+07
2249	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 23:47:21.203+07
2250	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 23:50:30.04+07
2251	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 23:54:43.275+07
2252	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-15 23:57:09.86+07
2253	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-15 23:57:25.79+07
2254	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 00:03:42.909+07
2255	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 00:05:49.672+07
2256	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 00:10:01.016+07
2257	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 00:10:01.812+07
2258	8	0	Aktivitas Logout	Tutik Murniati, SE baru saja sgn out dari SI Task Management.	2014-06-16 00:11:36.137+07
2259	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-16 00:11:50.924+07
2260	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-16 00:12:00.837+07
2261	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-16 00:14:02.854+07
2262	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-16 00:14:10.731+07
2263	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-16 00:14:38.719+07
2264	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-16 00:16:03.974+07
2265	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 00:16:14.727+07
2267	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 00:18:39.968+07
2272	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 00:24:25.565+07
2273	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 00:25:14.73+07
2278	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-16 00:35:09.902+07
2289	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 00:43:49.744+07
2266	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 00:17:04.151+07
2274	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 00:25:30.89+07
2277	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-16 00:34:06.799+07
2268	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 00:19:50.895+07
2290	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 00:43:56.158+07
2291	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 00:47:53.243+07
2293	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja membuat draft pekerjaan.	2014-06-16 00:49:17.405+07
2294	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 00:50:20.197+07
2269	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 00:22:43.53+07
2284	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-16 00:39:03.335+07
2285	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-16 00:39:28.591+07
2292	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 00:48:40.389+07
2270	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 00:23:24.303+07
2286	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 00:40:05.39+07
2296	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-16 00:55:05.336+07
2271	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 00:24:07.007+07
2275	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 00:33:01.626+07
2276	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 00:33:55.992+07
2279	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 00:35:20.984+07
2280	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 00:38:32.209+07
2281	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 00:38:42.281+07
2282	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-16 00:38:46.873+07
2283	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 00:38:56.469+07
2287	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-16 00:42:17.302+07
2288	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 00:43:42.19+07
2295	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja membuat draft pekerjaan.	2014-06-16 00:50:48.715+07
2297	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 05:22:55.905+07
2298	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 05:23:37.061+07
2299	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2014-06-16 05:23:56.659+07
2300	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 05:24:05.507+07
2301	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 05:30:47.014+07
2302	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 05:31:43.227+07
2303	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2014-06-16 05:33:46.301+07
2304	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja melakukan perubahan pada detail pekerjaan.	2014-06-16 05:34:05.641+07
2305	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2014-06-16 05:34:35.355+07
2306	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja melakukan validasi terhadap usulan pekerjaan dari staffnya	2014-06-16 05:34:41.875+07
2307	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-16 05:34:49.302+07
2308	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 05:35:00.014+07
2309	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-16 05:35:06.113+07
2310	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 05:35:16.737+07
2311	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-16 05:36:44.73+07
2312	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 05:36:51.321+07
2313	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 05:46:47.098+07
2314	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 05:47:34.305+07
2315	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 05:49:29.614+07
2316	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 05:52:59.238+07
2317	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 05:54:42.227+07
2318	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 05:55:05.756+07
2319	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 05:57:15.012+07
2320	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 05:57:31.469+07
2321	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 05:57:52.076+07
2322	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 06:09:51.653+07
2323	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 06:10:29.435+07
2324	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 06:12:14.738+07
2325	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 06:12:49.27+07
2326	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 06:13:04.91+07
2327	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 06:13:18.915+07
2328	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 08:02:20.949+07
2329	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-16 08:04:11.629+07
2330	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-16 08:04:39.761+07
2331	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 08:05:57.397+07
2332	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 08:11:43.923+07
2333	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 08:14:37.275+07
2334	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 08:16:50.637+07
2335	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 08:20:53.064+07
2336	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 08:21:42.287+07
2337	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 08:22:39.941+07
2338	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 08:23:15.387+07
2339	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 08:23:57.813+07
2340	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 08:28:01.214+07
2341	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 08:31:59.911+07
2342	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 08:32:25.546+07
2343	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 08:32:49.068+07
2344	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 08:33:00.165+07
2345	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 08:33:25.035+07
2346	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 08:34:26.22+07
2347	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 08:35:49.542+07
2348	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 08:36:02.702+07
2349	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 08:36:48.585+07
2350	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 08:37:21.629+07
2351	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 09:20:04.113+07
2352	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 09:20:18.216+07
2353	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 09:20:18.329+07
2354	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 09:20:18.334+07
2355	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 09:20:41.863+07
2356	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-16 09:40:48.912+07
2357	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja mengusulkan pekerjaan.	2014-06-16 09:41:32.163+07
2358	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-16 09:41:32.423+07
2359	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat daftar usulan pekerjaan yang ada.	2014-06-16 09:43:34.742+07
2360	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 09:43:37.623+07
2361	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 09:43:54.108+07
2362	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 09:44:04.739+07
2363	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 09:44:18.891+07
2364	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 09:53:41.61+07
2365	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 10:14:07.165+07
2366	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat laporan pekerjaan dari para staffnya.	2014-06-16 10:17:03.485+07
2367	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 10:17:55.452+07
2368	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 10:18:03.35+07
2369	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat laporan pekerjaan dari para staffnya.	2014-06-16 10:18:39.545+07
2370	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 10:21:22.191+07
2371	6	0	Aktivitas Logout	Sunarso Suyoso, dr, Sp.KK(K) baru saja sgn out dari SI Task Management.	2014-06-16 10:21:34.749+07
2372	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2014-06-16 10:21:50.31+07
2373	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 10:22:00.205+07
2374	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2014-06-16 10:49:44.209+07
2375	1	0	Aktivitas Logout	dr. Dodo Anondo, MPH baru saja sgn out dari SI Task Management.	2014-06-16 10:50:06.649+07
2376	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 10:52:22.093+07
2377	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat laporan pekerjaan dari para staffnya.	2014-06-16 10:52:54.754+07
2378	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 10:54:47.199+07
2379	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-16 10:56:09.089+07
2380	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-16 10:56:20.075+07
2381	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-16 10:57:02.675+07
2382	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat laporan pekerjaan dari para staffnya.	2014-06-16 11:01:18.842+07
2383	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat laporan pekerjaan dari para staffnya.	2014-06-16 11:01:29.273+07
2384	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 11:05:02.502+07
2385	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 11:11:32.518+07
2386	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 11:11:37.36+07
2387	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-16 11:11:46.288+07
2388	10	0	Aktivitas Pekerjaan	Widyowati sedang berada di halaman pekerjaan.	2014-06-16 11:22:27.454+07
2389	10	0	Aktivitas Pekerjaan	Widyowati sedang berada di halaman pekerjaan.	2014-06-16 11:23:01.491+07
2390	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 11:42:56.741+07
2391	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 20:54:32.027+07
2392	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 21:12:48.688+07
2393	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-16 21:30:30.269+07
2394	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 21:57:23.655+07
2395	6	0	Aktivitas Logout	Sunarso Suyoso, dr, Sp.KK(K) baru saja sgn out dari SI Task Management.	2014-06-16 21:57:29.334+07
2396	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 21:57:50.325+07
2397	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 21:58:14.462+07
2398	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 21:59:50.214+07
2399	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 22:00:36.066+07
2400	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-16 22:01:08.417+07
2401	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-16 22:01:37.77+07
2402	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-16 22:01:54.924+07
2403	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-16 22:02:13.409+07
2404	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-16 22:03:52.007+07
2405	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-16 22:04:46.837+07
2406	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-17 15:21:58.642+07
2407	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat daftar usulan pekerjaan yang ada.	2014-06-17 15:38:06.98+07
2408	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-18 13:27:06.917+07
2409	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-18 13:34:11.623+07
2410	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-18 13:38:05.487+07
2411	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-18 13:39:39.307+07
2412	6	0	Aktivitas Logout	Sunarso Suyoso, dr, Sp.KK(K) baru saja sgn out dari SI Task Management.	2014-06-18 13:46:49.271+07
2413	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-18 13:47:13.883+07
2414	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-18 13:54:19.394+07
2415	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-18 13:57:06.02+07
2416	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-18 13:57:16.51+07
2417	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-18 13:57:35.013+07
2418	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-18 13:59:36.654+07
2419	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-18 14:00:01.587+07
2420	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-18 14:00:26.297+07
2421	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-18 14:03:43.876+07
2422	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-18 14:05:26.491+07
2423	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-18 14:07:48.489+07
2424	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-18 14:09:10.845+07
2425	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-18 14:12:21.709+07
2426	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-18 14:12:34.679+07
2427	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-18 14:13:04.299+07
2428	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-18 14:14:18.118+07
2429	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-18 14:14:34.992+07
2430	6	0	Aktivitas Logout	Sunarso Suyoso, dr, Sp.KK(K) baru saja sgn out dari SI Task Management.	2014-06-18 14:15:03.767+07
2431	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-18 14:17:33.919+07
2432	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-18 14:20:47.968+07
2433	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-18 14:20:58.37+07
2434	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-18 14:25:16.572+07
2435	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-18 20:10:34.118+07
2436	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-18 20:10:48.081+07
2437	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-18 21:18:23.347+07
2438	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-18 21:19:06.227+07
2439	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-18 21:38:20.773+07
2440	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-19 12:17:16.901+07
2441	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-19 12:17:47.939+07
2442	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-19 17:11:15.419+07
2443	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-19 17:11:40.762+07
2444	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat laporan pekerjaan dari para staffnya.	2014-06-19 17:13:08.741+07
2445	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-19 19:25:11.543+07
2446	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-19 19:25:35.161+07
2447	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-19 19:25:43.445+07
2448	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-19 19:38:32.647+07
2449	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-19 19:38:47.476+07
2450	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-19 19:40:37.9+07
2451	6	0	Aktivitas Logout	Sunarso Suyoso, dr, Sp.KK(K) baru saja sgn out dari SI Task Management.	2014-06-19 19:40:55.61+07
2452	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-19 19:41:08.917+07
2453	10	0	Aktivitas Pekerjaan	Widyowati sedang melihat detail tentang pekerjaannya.	2014-06-19 19:41:22.063+07
2454	10	0	Aktivitas Pekerjaan	Widyowati sedang berada di halaman pekerjaan.	2014-06-19 19:41:34.214+07
2455	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-19 20:02:20.986+07
2456	10	0	Aktivitas Login	Widyowati sedang berada di halaman dashboard.	2014-06-19 20:07:58.409+07
2457	4	0	Aktivitas Login	Dra. Sri Widayati,Apt.,Sp.FRS sedang berada di halaman dashboard.	2014-06-19 20:16:17.476+07
2458	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2014-06-19 20:18:07.823+07
2459	4	0	Aktivitas Pekerjaan	Dra. Sri Widayati,Apt.,Sp.FRS sedang melihat daftar usulan pekerjaan yang ada.	2014-06-19 20:20:04.608+07
2460	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2014-06-19 20:24:02.191+07
2461	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2014-06-19 20:25:44.996+07
2462	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2014-06-19 20:26:26.19+07
2463	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2014-06-19 20:27:04.876+07
2464	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2014-06-19 20:29:55.795+07
2465	4	0	Aktivitas Pekerjaan	Dra. Sri Widayati,Apt.,Sp.FRS sedang melihat detail tentang pekerjaannya.	2014-06-19 20:36:28.771+07
2466	4	0	Aktivitas Logout	Dra. Sri Widayati,Apt.,Sp.FRS baru saja sgn out dari SI Task Management.	2014-06-19 20:37:03.38+07
2467	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2014-06-19 20:37:28.815+07
2468	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2014-06-19 20:38:13.617+07
2469	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat daftar usulan pekerjaan yang ada.	2014-06-19 20:38:20.652+07
2470	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja melakukan perubahan pada detail pekerjaan.	2014-06-19 20:38:26.67+07
2471	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2014-06-19 20:39:08.282+07
2472	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2014-06-19 20:39:15.817+07
2473	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja melakukan perubahan pada detail pekerjaan.	2014-06-19 20:39:25.487+07
2474	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja melakukan perubahan pada detail pekerjaan.	2014-06-19 20:39:37.259+07
2475	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja melakukan perubahan pada detail pekerjaan.	2014-06-19 20:39:37.261+07
2476	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja melakukan perubahan pada detail pekerjaan.	2014-06-19 20:39:37.264+07
2477	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja melakukan perubahan pada detail pekerjaan.	2014-06-19 20:41:11.489+07
2478	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2014-06-19 20:41:39.962+07
2479	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2014-06-19 20:42:13.387+07
2480	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2014-06-19 20:42:51.227+07
2481	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat daftar usulan pekerjaan yang ada.	2014-06-19 20:42:58.084+07
2482	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-19 20:43:30.548+07
2483	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2014-06-19 20:43:55.099+07
2488	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat progress pekerjaan dari para staffnya.	2014-06-19 20:52:45.044+07
2490	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-19 20:53:04.672+07
2484	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2014-06-19 20:45:00.016+07
2487	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2014-06-19 20:51:51.908+07
2485	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2014-06-19 20:46:12.743+07
2486	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-19 20:49:41.202+07
2489	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-19 20:52:48.853+07
2498	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja melakukan perubahan pada detail pekerjaan.	2014-06-19 20:56:52.851+07
2502	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2014-06-19 20:57:36.512+07
2505	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-19 21:01:04.749+07
2506	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-19 21:06:01.018+07
2491	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-19 20:53:59.66+07
2492	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2014-06-19 20:54:09.302+07
2493	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2014-06-19 20:54:13.467+07
2494	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2014-06-19 20:54:29.735+07
2495	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2014-06-19 20:55:26.149+07
2496	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2014-06-19 20:55:36.794+07
2497	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2014-06-19 20:56:45.954+07
2500	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2014-06-19 20:57:04.29+07
2501	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2014-06-19 20:57:09.424+07
2503	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2014-06-19 20:57:46.504+07
2504	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2014-06-19 20:57:47.755+07
2507	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja mengusulkan pekerjaan.	2014-06-19 21:10:37.62+07
2508	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2014-06-19 21:10:37.827+07
2499	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja melakukan perubahan pada detail pekerjaan.	2014-06-19 20:56:52.968+07
2509	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja melakukan perubahan pada detail pekerjaan.	2014-06-19 21:21:15.768+07
2510	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2014-06-19 21:21:30.222+07
2511	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-10-01 14:00:37.314+07
2512	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-01 14:00:45.821+07
2513	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-10-01 14:00:55.26+07
2514	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-01 14:01:13.141+07
2515	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-10-01 14:01:27.818+07
2516	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-01 14:01:31.713+07
2517	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-10-01 14:01:37.111+07
2518	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-01 14:01:41.372+07
2519	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-10-01 14:01:46.209+07
2520	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-01 14:06:02.746+07
2521	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-10-01 14:06:12.117+07
2522	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-01 14:06:16.053+07
2523	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-10-01 14:06:20.5+07
2524	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-01 14:06:28.728+07
2525	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-10-01 14:12:38.096+07
2526	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-10-01 14:12:48.366+07
2527	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja memberikan pekerjaan kepada staffnya.	2015-10-01 14:13:09.375+07
2528	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja memberikan pekerjaan kepada staffnya.	2015-10-01 14:15:32.033+07
2529	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja memberikan pekerjaan kepada staffnya.	2015-10-01 14:36:10.243+07
2530	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja memberikan pekerjaan kepada staffnya.	2015-10-01 14:38:31.347+07
2531	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja memberikan pekerjaan kepada staffnya.	2015-10-01 14:56:23.047+07
2532	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja memberikan pekerjaan kepada staffnya.	2015-10-01 14:57:21.942+07
2533	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja memberikan pekerjaan kepada staffnya.	2015-10-01 14:57:38.981+07
2534	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja memberikan pekerjaan kepada staffnya.	2015-10-01 15:08:58.622+07
2535	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja memberikan pekerjaan kepada staffnya.	2015-10-01 15:12:36.156+07
2536	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja memberikan pekerjaan kepada staffnya.	2015-10-01 15:15:28.254+07
2537	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja memberikan pekerjaan kepada staffnya.	2015-10-01 15:15:34.456+07
2538	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja memberikan pekerjaan kepada staffnya.	2015-10-01 15:15:47.374+07
2539	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja memberikan pekerjaan kepada staffnya.	2015-10-01 15:17:23.836+07
2540	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja memberikan pekerjaan kepada staffnya.	2015-10-01 15:17:32.663+07
2541	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja memberikan pekerjaan kepada staffnya.	2015-10-01 15:19:54.452+07
2542	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-02 11:05:43.03+07
2543	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-10-02 11:05:53.407+07
2544	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-02 11:05:57.633+07
2545	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-10-02 11:06:02.114+07
2546	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-02 11:06:05.432+07
2547	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-10-02 11:06:09.676+07
2548	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-02 11:06:13.418+07
2549	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-10-02 11:06:17.027+07
2550	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-02 11:06:20.839+07
2551	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-10-02 11:06:23.913+07
2552	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-02 11:06:27.752+07
2553	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-10-02 11:06:34.211+07
2554	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-02 11:06:38.372+07
2555	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-10-02 11:06:41.968+07
2556	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-02 11:06:46.196+07
2557	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-10-02 11:06:49.703+07
2558	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-02 11:06:53.253+07
2559	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-10-02 11:06:56.035+07
2560	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-02 11:07:00.244+07
2561	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-10-02 11:07:05.941+07
2562	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-02 11:07:11.164+07
2563	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-10-02 11:07:14.602+07
2564	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-02 11:07:18.456+07
2565	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-10-02 11:07:22.15+07
2566	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-02 11:07:26.044+07
2567	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-10-02 11:07:34.083+07
2568	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-02 11:07:37.811+07
2569	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-10-02 11:07:40.907+07
2570	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-02 11:07:43.902+07
2571	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-10-02 11:07:46.537+07
2572	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja melakukan perubahan pada detail pekerjaan.	2015-10-02 11:07:48.179+07
2573	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-02 11:07:54.159+07
2574	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-06 12:43:05.852+07
2575	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-10-06 12:45:12.304+07
2576	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja memberikan pekerjaan kepada staffnya.	2015-10-06 12:45:35.093+07
2577	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-10-06 12:45:47.593+07
2578	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-06 12:45:59.208+07
2579	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-10-06 12:46:08.208+07
2580	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-06 12:46:16.641+07
2581	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-10-06 12:47:29.106+07
2582	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-10-06 12:47:34.26+07
2583	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja membuat draft pekerjaan.	2015-10-06 12:50:01.769+07
2584	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-06 12:50:22.31+07
2585	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2015-10-06 12:59:50.487+07
2586	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2015-10-06 13:01:21.459+07
2587	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2015-10-06 13:05:04.719+07
2588	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2015-10-06 13:05:11.222+07
2589	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2015-10-06 13:05:16.217+07
2590	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2015-10-06 13:05:42.292+07
2591	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2015-10-06 13:05:47.428+07
2592	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2015-10-06 13:05:57.408+07
2593	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2015-10-06 13:06:06.69+07
2594	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2015-10-06 13:07:43.355+07
2595	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2015-10-06 13:07:49.262+07
2596	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2015-10-06 13:07:59.485+07
2597	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-06 13:09:14.095+07
2598	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2015-10-06 13:14:48.22+07
2599	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2015-10-06 13:14:56.878+07
2600	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2015-10-06 13:15:11.473+07
2601	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2015-10-06 13:15:19.033+07
2602	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2015-10-06 13:15:32.314+07
2603	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2015-10-06 13:16:22.503+07
2604	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2015-10-06 13:16:32.216+07
2605	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2015-10-06 13:16:44.313+07
2606	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2015-10-06 13:17:04.179+07
2607	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan perubahan pada detail pekerjaan.	2015-10-06 13:17:08.461+07
2608	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2015-10-06 13:17:37.753+07
2609	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja melakukan validasi terhadap usulan pekerjaan dari staffnya	2015-10-06 13:18:13.552+07
2610	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2015-10-06 13:18:25.914+07
2611	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-06 13:18:53.128+07
2612	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-10-06 13:19:28.674+07
2613	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2015-10-06 13:19:34.496+07
2614	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja mengusulkan pekerjaan.	2015-10-06 13:20:14.169+07
2615	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2015-10-06 13:20:14.442+07
2616	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-06 13:20:37.988+07
2617	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2015-10-06 13:21:09.103+07
2618	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2015-10-06 13:22:26.238+07
2619	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2015-10-06 13:23:33.873+07
2620	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) baru saja mengusulkan pekerjaan.	2015-10-06 13:23:56.569+07
2621	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2015-10-06 13:23:56.989+07
2622	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2015-10-06 13:24:08.856+07
2623	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2015-10-06 13:28:57.355+07
2624	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2015-10-06 13:29:14.031+07
2625	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2015-10-06 13:29:53.511+07
2626	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2015-10-06 13:30:07.746+07
2627	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2015-10-06 13:30:19.203+07
2628	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2015-10-06 13:30:53.162+07
2629	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2015-10-06 13:31:34.299+07
2630	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang melihat detail tentang pekerjaannya.	2015-10-06 13:31:43.308+07
2631	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2015-10-06 13:32:06.9+07
2632	6	0	Aktivitas Pekerjaan	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman pekerjaan.	2015-10-06 13:32:20.334+07
2633	6	0	Aktivitas Login	Sunarso Suyoso, dr, Sp.KK(K) sedang berada di halaman dashboard.	2015-10-06 13:32:53.898+07
2634	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-07 09:06:08.723+07
2635	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-10-07 09:07:23.967+07
2636	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja memberikan pekerjaan kepada staffnya.	2015-10-07 09:07:50.221+07
2637	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja memberikan pekerjaan kepada staffnya.	2015-10-07 09:25:54.054+07
2638	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-07 09:34:36.82+07
2639	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-10-07 09:34:46.135+07
2640	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-10-07 09:34:50.602+07
2641	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-07 09:34:58.576+07
2642	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-10-07 09:35:04.589+07
2643	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-10-07 09:35:30.133+07
2644	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-10-07 09:35:40.748+07
2645	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja memberikan pekerjaan kepada staffnya.	2015-10-07 09:36:07.768+07
2646	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja memberikan pekerjaan kepada staffnya.	2015-10-07 09:38:31.393+07
2647	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-07 16:19:49.864+07
2648	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-10-07 16:26:24.873+07
2649	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja memberikan pekerjaan kepada staffnya.	2015-10-07 16:26:42.547+07
2650	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-10-07 16:26:42.746+07
2651	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-10-07 16:26:50.797+07
2652	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-10-07 16:26:55.63+07
2653	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-10-07 16:27:01.601+07
2654	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-10-07 16:27:04.864+07
2655	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-10-07 16:27:29.144+07
2656	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-10-07 16:27:40.643+07
2657	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-10-07 16:28:35.147+07
2658	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-10-07 16:28:38.187+07
2659	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-07 16:53:20.795+07
2660	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-10-07 16:54:08.158+07
2661	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-10-07 16:54:21.472+07
2662	1	0	Aktivitas Profil	dr. Dodo Anondo, MPH sedang melihat profil miliknya sendiri..	2015-10-07 16:55:10.583+07
2663	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-10-07 16:55:36.245+07
2664	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-10-07 16:59:42.831+07
2665	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-10-07 17:01:28.527+07
2666	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-10-07 17:02:31.086+07
2667	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-10-07 17:03:08.975+07
2668	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-10-07 17:04:47.322+07
2669	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-10-07 17:05:18.224+07
2670	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-10-07 17:11:24.684+07
2671	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-10-07 17:11:35.988+07
2672	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-10-07 17:12:00.772+07
2673	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-10-07 17:12:07.052+07
2674	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-10-07 17:12:21.533+07
2675	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-10-07 17:14:16.783+07
2676	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-10-07 17:14:27.785+07
2677	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-10-07 17:14:38.082+07
2678	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-10-07 17:15:45.991+07
2679	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-10-07 17:15:52.153+07
2680	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-10-07 20:05:21.575+07
2681	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-11-17 10:09:22.372+07
2682	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-11-17 10:09:41.786+07
2683	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 10:09:53.816+07
2684	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH baru saja memberikan pekerjaan kepada staffnya.	2015-11-17 10:26:11.111+07
2685	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 10:26:11.841+07
2686	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-11-17 10:26:21.58+07
2687	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-11-17 10:26:42.242+07
2688	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-11-17 10:26:50.692+07
2689	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-11-17 10:27:21.76+07
2690	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-11-17 10:27:27.429+07
2691	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-11-17 10:27:39.485+07
2692	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-11-17 10:30:36.498+07
2693	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-11-17 10:33:08.025+07
2694	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-11-17 10:35:12.351+07
2695	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-11-17 10:35:56.172+07
2696	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-11-17 10:40:27.824+07
2697	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-11-17 10:40:58.431+07
2698	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-11-17 10:40:58.466+07
2699	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-11-17 10:42:14.271+07
2700	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-11-17 10:42:37.437+07
2701	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-11-17 10:43:04.739+07
2702	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-11-17 10:43:38.865+07
2703	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-11-17 10:43:44.005+07
2704	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-11-17 13:21:03.025+07
2705	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 13:21:23.922+07
2706	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 13:25:59.589+07
2707	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 13:26:04.179+07
2708	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 13:27:09.411+07
2709	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 13:30:23.413+07
2710	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 13:30:49.948+07
2711	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 13:31:06.149+07
2712	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 13:33:43.97+07
2713	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 13:35:49.366+07
2714	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 13:36:05.349+07
2715	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 13:45:19.755+07
2716	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 13:47:11.002+07
2717	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 13:51:36.932+07
2718	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 13:52:41.197+07
2719	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 13:52:50.515+07
2720	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 13:57:15.97+07
2721	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 13:58:05.676+07
2722	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 13:59:18.494+07
2723	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 14:01:27.194+07
2724	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 14:04:57.202+07
2725	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 14:11:12.16+07
2726	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 14:11:31.131+07
2727	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 14:12:07.542+07
2728	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 14:13:08.402+07
2729	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 14:13:32.405+07
2730	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-11-17 14:27:05.353+07
2731	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-11-17 14:27:16.194+07
2732	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 14:27:18.833+07
2733	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 14:30:53.878+07
2734	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 14:31:47.933+07
2735	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 15:53:57.925+07
2736	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 16:14:30.397+07
2739	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-11-17 20:10:58.627+07
2737	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 16:17:41.078+07
2738	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 16:19:03.531+07
2749	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-18 09:32:00.903+07
2775	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-19 08:58:58.045+07
2791	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-19 13:57:04.518+07
2799	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-20 16:04:08.624+07
2807	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-20 16:16:42.925+07
2809	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-20 16:22:58.333+07
2810	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-20 16:24:05.2+07
2740	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 20:11:16.311+07
2741	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 20:11:37.678+07
2742	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 20:13:12.831+07
2743	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 20:14:51.268+07
2744	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 20:15:24.873+07
2746	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 20:17:30.118+07
2747	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 20:21:26.645+07
2751	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-18 10:38:15.706+07
2757	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-19 05:21:46.26+07
2763	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-19 06:13:58.716+07
2778	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-19 09:36:51.99+07
2787	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-19 13:48:19.337+07
2792	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-19 14:43:06.404+07
2804	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-20 16:12:00.677+07
2808	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-20 16:21:15.304+07
2745	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-17 20:16:11.451+07
2779	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-19 09:42:25.405+07
2790	2	0	Aktivitas Login	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman dashboard.	2015-11-19 13:56:57.898+07
2794	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-11-20 15:53:57.75+07
2802	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-20 16:08:15.336+07
2811	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-20 16:25:09.032+07
2748	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-11-18 09:31:53.817+07
2750	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-18 10:37:52.236+07
2752	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-11-18 13:18:00.85+07
2758	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-19 06:02:51.315+07
2769	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-19 06:21:19.599+07
2770	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-19 06:21:48.476+07
2753	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat detail tentang pekerjaannya.	2015-11-18 13:18:08.36+07
2754	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-11-18 20:48:36.312+07
2755	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-18 20:48:45.224+07
2759	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-11-19 06:03:45.336+07
2762	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-19 06:04:21.021+07
2764	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-19 06:14:09.492+07
2766	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-19 06:18:55.704+07
2767	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-19 06:19:06.18+07
2771	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-19 06:23:01.504+07
2772	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-19 06:23:45.553+07
2773	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-19 06:25:28.737+07
2776	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-19 09:36:23.488+07
2780	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-19 09:51:24.402+07
2786	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-11-19 13:39:20.681+07
2793	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-19 14:44:27.654+07
2795	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-11-20 15:56:23.906+07
2796	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-20 15:56:33.484+07
2803	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-20 16:10:48.924+07
2756	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-11-19 05:19:22.363+07
2765	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-19 06:17:19.76+07
2777	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-19 09:36:43.99+07
2781	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-19 09:52:14.466+07
2785	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-19 09:54:28.602+07
2788	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-19 13:49:20.174+07
2789	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-19 13:54:16.698+07
2760	1	0	Aktivitas Logout	dr. Dodo Anondo, MPH baru saja sgn out dari SI Task Management.	2015-11-19 06:04:04.912+07
2761	2	0	Aktivitas Login	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman dashboard.	2015-11-19 06:04:14.577+07
2768	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-19 06:19:41.145+07
2774	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-11-19 08:58:52.917+07
2797	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-11-20 16:00:11.613+07
2798	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-20 16:00:36+07
2800	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-20 16:06:17.408+07
2782	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-19 09:53:00.891+07
2783	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-19 09:53:42.216+07
2784	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-19 09:54:17.435+07
2801	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-20 16:07:12.791+07
2805	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-20 16:13:10.627+07
2806	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-20 16:16:02.459+07
2812	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang berada di halaman pekerjaan.	2015-11-20 16:40:18.688+07
2813	2	0	Aktivitas Login	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman dashboard.	2015-11-20 16:48:19.216+07
2814	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-20 16:48:25.829+07
2815	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-20 16:48:56.533+07
2816	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-20 16:50:03.818+07
2817	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-20 16:51:02.528+07
2818	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-20 16:51:59.794+07
2819	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-20 16:52:13.19+07
2820	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-20 16:53:03.933+07
2821	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-20 16:56:38.672+07
2822	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-20 17:16:49.821+07
2823	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-20 17:17:44.704+07
2824	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-11-22 09:53:42.826+07
2825	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-22 09:53:49.234+07
2826	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-11-22 12:06:54.848+07
2827	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-22 12:07:09.275+07
2828	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-22 12:09:08.249+07
2829	2	0	Aktivitas Login	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman dashboard.	2015-11-22 12:09:48.192+07
2830	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 12:09:51.872+07
2831	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 12:17:34.531+07
2832	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 12:19:18.31+07
2833	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 12:27:33.052+07
2834	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 12:27:59.913+07
2835	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 12:28:22.857+07
2836	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 12:31:26.79+07
2837	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-11-22 12:37:48.457+07
2838	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-22 12:38:45.704+07
2839	2	0	Aktivitas Login	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman dashboard.	2015-11-22 12:45:44.644+07
2840	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 12:45:50.124+07
2841	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 12:50:20.397+07
2842	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 12:51:26.289+07
2843	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 12:52:08.562+07
2844	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 12:52:57.806+07
2845	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-22 12:56:14.418+07
2846	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 12:57:01.099+07
2847	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 12:59:18.319+07
2848	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 13:05:33.763+07
2849	2	0	Aktivitas Login	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman dashboard.	2015-11-22 13:09:43.48+07
2850	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-11-22 13:48:59.508+07
2851	2	0	Aktivitas Login	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman dashboard.	2015-11-22 13:50:14.403+07
2852	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 13:51:03.292+07
2853	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-22 13:52:27.467+07
2854	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 13:52:41.163+07
2855	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 13:52:51.496+07
2856	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 13:55:05.357+07
2857	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 13:57:52.214+07
2858	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 13:58:44.683+07
2859	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 13:59:40.777+07
2860	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 14:00:39.839+07
2861	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-22 14:01:04.907+07
2862	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 14:02:06.055+07
2863	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 14:03:22.62+07
2864	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 14:04:21.906+07
2867	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 14:12:10.186+07
2889	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 14:52:06.802+07
2865	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 14:05:18.988+07
2866	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 14:05:43.181+07
2869	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 14:12:55.685+07
2879	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang melihat progress pekerjaan dari para staffnya.	2015-11-22 14:40:35.043+07
2868	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-22 14:12:27.989+07
2870	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang melihat progress pekerjaan dari para staffnya.	2015-11-22 14:13:02.753+07
2873	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-22 14:13:22.239+07
2876	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-22 14:24:14.654+07
2878	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-22 14:32:26.665+07
2881	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 14:42:30.598+07
2871	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang melihat progress pekerjaan dari para staffnya.	2015-11-22 14:13:12.89+07
2872	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang melihat progress pekerjaan dari para staffnya.	2015-11-22 14:13:17.463+07
2874	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-22 14:18:18.765+07
2875	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-22 14:22:03.203+07
2877	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-22 14:28:52.396+07
2880	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 14:40:40.424+07
2882	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 14:43:32.482+07
2883	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 14:45:19.434+07
2884	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-22 14:47:25.714+07
2886	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang melihat progress pekerjaan dari para staffnya.	2015-11-22 14:51:01.272+07
2888	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 14:52:02.455+07
2890	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 14:52:19.788+07
2891	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-22 14:53:01.958+07
2885	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-22 14:49:59.685+07
2887	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-22 14:51:11.683+07
2892	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-11-23 13:29:18.379+07
2893	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-23 13:29:30.448+07
2894	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-23 13:38:34.949+07
2895	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-23 13:41:08.437+07
2896	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-23 13:42:16.563+07
2897	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-23 13:43:17.646+07
2898	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-23 13:49:57.005+07
2899	2	0	Aktivitas Login	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman dashboard.	2015-11-23 14:10:08.022+07
2900	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang melihat progress pekerjaan dari para staffnya.	2015-11-23 14:10:15.202+07
2901	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-23 14:10:36.21+07
2902	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-23 14:11:12.351+07
2903	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-23 14:15:34.662+07
2904	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-23 14:16:06.159+07
2905	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-23 14:18:59.787+07
2906	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-23 14:19:09.84+07
2907	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-23 14:19:56.941+07
2908	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-23 14:20:25.774+07
2909	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-23 14:20:53.995+07
2910	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-23 14:28:03.336+07
2911	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-23 14:28:28.853+07
2912	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-23 14:28:43.381+07
2913	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-23 14:29:31.979+07
2914	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-11-23 17:03:59.808+07
2915	1	0	Aktivitas Login	dr. Dodo Anondo, MPH sedang berada di halaman dashboard.	2015-11-25 11:23:36.083+07
2916	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-25 11:23:55.631+07
2917	2	0	Aktivitas Login	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman dashboard.	2015-11-25 11:32:28.146+07
2918	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-25 11:32:33.374+07
2919	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-25 12:02:12.33+07
2920	2	0	Aktivitas Pekerjaan	Drs. Pungky Hendriastjarjo, M.Ak sedang berada di halaman pekerjaan.	2015-11-25 12:29:53.079+07
2921	1	0	Aktivitas Pekerjaan	dr. Dodo Anondo, MPH sedang melihat progress pekerjaan dari para staffnya.	2015-11-25 12:52:21.184+07
\.


--
-- Data for Name: aktivitas_pekerjaan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY aktivitas_pekerjaan (id_aktivitas, id_pekerjaan, id_akun, tanggal_transaksi, waktu_mulai, waktu_selesai, kuantitas_output, kualitas_mutu, biaya, angka_kredit, keterangan, status_validasi) FROM stdin;
20	179	2	2015-11-25 12:09:23.48+07	2015-11-23 00:00:00+07	2015-11-27 00:00:00+07	10	100	0	0	ket	0
\.


--
-- Name: aktivitas_pekerjaan_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('aktivitas_pekerjaan_seq', 20, true);


--
-- Data for Name: detil_pekerjaan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY detil_pekerjaan (id_detil_pekerjaan, id_pekerjaan, id_akun, tgl_read, tglasli_mulai, tglasli_selesai, skor, progress, status, sasaran_angka_kredit, sasaran_kuantitas_output, sasaran_kualitas_mutu, sasaran_waktu, sasaran_biaya, realisasi_angka_kredit, realisasi_kuantitas_output, realisasi_kualitas_mutu, realisasi_waktu, realisasi_biaya, pakai_biaya, satuan_kuantitas, satuan_waktu) FROM stdin;
243	181	3	\N	\N	\N	0	0	\N	0	0	0	0	0	0	0	0	0	0	1	item	bulan
244	181	5	\N	\N	\N	0	0	\N	0	0	0	0	0	0	0	0	0	0	1	item	bulan
245	181	7	\N	\N	\N	0	0	\N	0	0	0	0	0	0	0	0	0	0	1	item	bulan
246	181	20	\N	\N	\N	0	0	\N	0	0	0	0	0	0	0	0	0	0	1	item	bulan
239	180	2	2015-11-23	\N	\N	0	0	\N	0	0	0	0	0	0	0	0	0	0	1	item	bulan
237	179	2	2015-11-22	\N	\N	0	0	\N	1	100	100	12	100	0	0	0	0	0	1	po	bulan
238	179	3	\N	\N	\N	0	0	\N	1	100	100	12	100	0	0	0	0	0	1	po	bulan
240	180	3	\N	\N	\N	0	0	\N	0	0	0	0	0	0	0	0	0	0	1	item	bulan
241	180	4	\N	\N	\N	0	0	\N	0	0	0	0	0	0	0	0	0	0	1	item	bulan
242	181	2	2015-11-23	\N	\N	0	0	\N	0	0	0	0	0	0	0	0	0	0	1	item	bulan
247	182	2	\N	\N	\N	0	0	\N	1	1000	100	12	1000000	0	0	0	0	0	1	item	bulan
248	182	3	\N	\N	\N	0	0	\N	1	1000	100	12	1000000	0	0	0	0	0	1	item	bulan
\.


--
-- Data for Name: detil_progress; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY detil_progress (id_detil_progress, id_detil_pekerjaan, deksripsi, progress, total_progress, waktu) FROM stdin;
\.


--
-- Name: detil_progress_id_detil_progress_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('detil_progress_id_detil_progress_seq', 16, true);


--
-- Data for Name: file; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY file (id_file, id_pekerjaan, nama_file, waktu, id_progress) FROM stdin;
\.


--
-- Data for Name: komentar; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY komentar (id_komentar, id_akun, id_pekerjaan, isi_komentar, tgl_komentar, history_komentar) FROM stdin;
\.


--
-- Data for Name: nilai_pekerjaan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY nilai_pekerjaan (id_nilai, ak, kuatitas_output, kualitas_mutu, waktu, biaya, penghitungan, nilai_skp, satuan_waktu, id_detil_pekerjaan, id_tipe_nilai) FROM stdin;
\.


--
-- Name: nilai_pekerjaan_id_nilai_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('nilai_pekerjaan_id_nilai_seq', 48, true);


--
-- Data for Name: pekerjaan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY pekerjaan (id_pekerjaan, id_sifat_pekerjaan, parent_pekerjaan, nama_pekerjaan, deskripsi_pekerjaan, tgl_mulai, tgl_selesai, asal_pekerjaan, level_prioritas, flag_usulan, id_pengaduan, kategori, id_penanggung_jawab, id_pengusul, status_pekerjaan, periode, level_manfaat) FROM stdin;
179	2	\N	skp1	skp1	\N	\N	taskmanagement	1	\N	\N	skp	1	\N	7	2015	\N
180	1	\N	tambahan1	tambahan2	2015-11-22 00:00:00+07	2015-11-27 00:00:00+07	taskmanagement	1	\N	\N	tambahan	1	\N	7	\N	\N
181	1	\N	kreativitas1	kreativitas1	2015-11-23 00:00:00+07	2015-11-30 00:00:00+07	taskmanagement	1	\N	\N	kreativitas	1	\N	7	\N	1
182	1	\N	skp3	aa	\N	\N	taskmanagement	1	\N	\N	skp	1	\N	7	2015	\N
\.


--
-- Data for Name: pengaduan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY pengaduan (id_pengaduan, topik_pengaduan, isi_pengaduan, tanggal_pengaduan, rekomendasi_urgensitas, respon, alasan_respon) FROM stdin;
1	Sistem informasi absensi	<p>saya anak magang di RSUD di bagian poliklinik, ketika saya ingin absen di RSUD, sistem tidak berjalan. sehingga saya tidak dapat absen saat itu. Tolong kejelasan dari pihak ITKI. Trim</p>\r\n	2014-05-05 19:02:09+07	2	1	0
2	sfasfn	<p>ansdfksdnfknflfkn</p>\r\n	2014-05-07 09:44:19+07	2	1	0
3	sfasfn	<p>ansdfksdnfknflfkn</p>\r\n	2014-05-07 09:44:19+07	2	1	0
4	sfasfn	<p>ansdfksdnfknflfkn</p>\r\n	2014-05-07 09:44:19+07	2	1	0
5	sfasfn	<p>ansdfksdnfknflfkn</p>\r\n	2014-05-07 09:44:19+07	2	1	0
6	sfasfn	<p>ansdfksdnfknflfkn</p>\r\n	2014-05-07 09:44:19+07	2	1	0
7	Sistem informasi absensi	<p>saya anak magang di RSUD di bagian poliklinik, ketika saya ingin absen di RSUD, sistem tidak berjalan. sehingga saya tidak dapat absen saat itu. Tolong kejelasan dari pihak ITKI. Trim</p>\r\n	2014-05-05 19:02:09+07	1	1	0
8	Sistem informasi absensi	<p>saya anak magang di RSUD di bagian poliklinik, ketika saya ingin absen di RSUD, sistem tidak berjalan. sehingga saya tidak dapat absen saat itu. Tolong kejelasan dari pihak ITKI. Trim</p>\r\n	2014-05-05 19:02:09+07	1	1	0
9	Sistem informasi absensi	<p>saya anak magang di RSUD di bagian poliklinik, ketika saya ingin absen di RSUD, sistem tidak berjalan. sehingga saya tidak dapat absen saat itu. Tolong kejelasan dari pihak ITKI. Trim</p>\r\n	2014-05-05 19:02:09+07	1	1	0
10	Sistem informasi absensi	<p>saya anak magang di RSUD di bagian poliklinik, ketika saya ingin absen di RSUD, sistem tidak berjalan. sehingga saya tidak dapat absen saat itu. Tolong kejelasan dari pihak ITKI. Trim</p>\r\n	2014-05-05 19:02:09+07	1	1	0
11	Sistem informasi absensi	<p>saya anak magang di RSUD di bagian poliklinik, ketika saya ingin absen di RSUD, sistem tidak berjalan. sehingga saya tidak dapat absen saat itu. Tolong kejelasan dari pihak ITKI. Trim</p>\r\n	2014-05-05 19:02:09+07	1	1	0
12	Sistem informasi absensi	<p>saya anak magang di RSUD di bagian poliklinik, ketika saya ingin absen di RSUD, sistem tidak berjalan. sehingga saya tidak dapat absen saat itu. Tolong kejelasan dari pihak ITKI. Trim</p>\r\n	2014-05-05 19:02:09+07	1	1	0
13	Sistem informasi absensi	<p>saya anak magang di RSUD di bagian poliklinik, ketika saya ingin absen di RSUD, sistem tidak berjalan. sehingga saya tidak dapat absen saat itu. Tolong kejelasan dari pihak ITKI. Trim</p>\r\n	2014-05-05 19:02:09+07	1	1	0
14	Sistem informasi absensi	<p>saya anak magang di RSUD di bagian poliklinik, ketika saya ingin absen di RSUD, sistem tidak berjalan. sehingga saya tidak dapat absen saat itu. Tolong kejelasan dari pihak ITKI. Trim</p>\r\n	2014-05-05 19:02:09+07	1	1	0
15	Sistem informasi absensi	<p>saya anak magang di RSUD di bagian poliklinik, ketika saya ingin absen di RSUD, sistem tidak berjalan. sehingga saya tidak dapat absen saat itu. Tolong kejelasan dari pihak ITKI. Trim</p>\r\n	2014-05-05 19:02:09+07	2	1	0
\.


--
-- Name: pengaduan_id_pengaduan_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('pengaduan_id_pengaduan_seq', 15, true);


--
-- Name: primary_pemberi_pekerjaan; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('primary_pemberi_pekerjaan', 31, true);


--
-- Data for Name: sifat_pekerjaan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY sifat_pekerjaan (id_sifat_pekerjaan, nama_sifat_pekerjaan) FROM stdin;
1	Personal
2	Umum
\.


--
-- Data for Name: status; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY status (status_id, status_nama) FROM stdin;
1	Usulan
\.


--
-- Data for Name: status_pekerjaan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY status_pekerjaan (id_status_pekerjaan, nama_status_pekerjaan) FROM stdin;
1	Belum Dibaca
2	Sudah Dibaca
3	Dikerjakan
4	Selesai
5	Terlambat
6	Usulan
7	Approved
8	Minta Diperpanjang
\.


--
-- Name: tbl_activity_id; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tbl_activity_id', 2921, true);


--
-- Name: tbl_akun_id; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tbl_akun_id', 4, true);


--
-- Name: tbl_departemen_id; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tbl_departemen_id', 5, true);


--
-- Name: tbl_detil_pekerjaan_id; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tbl_detil_pekerjaan_id', 248, true);


--
-- Name: tbl_file_id; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tbl_file_id', 112, true);


--
-- Name: tbl_jabatan_id; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tbl_jabatan_id', 3, true);


--
-- Name: tbl_komentar_id; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tbl_komentar_id', 107, true);


--
-- Name: tbl_pekerjaan_id; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tbl_pekerjaan_id', 182, true);


--
-- Name: tbl_sifat_pkj_id; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tbl_sifat_pkj_id', 1, false);


--
-- Data for Name: tipe_nilai; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY tipe_nilai (id_tipe_nilai, nama_tipe, keterangan_tipe) FROM stdin;
2	realisasi	\N
1	target	\N
\.


--
-- Name: tipe_nilai_id_tipe_nilai_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tipe_nilai_id_tipe_nilai_seq', 2, true);


--
-- Name: aktivitas_pekerjaan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY aktivitas_pekerjaan
    ADD CONSTRAINT aktivitas_pekerjaan_pkey PRIMARY KEY (id_aktivitas);


--
-- Name: pengaduan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pengaduan
    ADD CONSTRAINT pengaduan_pkey PRIMARY KEY (id_pengaduan);


--
-- Name: pk_activity; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY activity
    ADD CONSTRAINT pk_activity PRIMARY KEY (id_activity);


--
-- Name: pk_detil_pekerjaan; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY detil_pekerjaan
    ADD CONSTRAINT pk_detil_pekerjaan PRIMARY KEY (id_detil_pekerjaan);


--
-- Name: pk_file; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY file
    ADD CONSTRAINT pk_file PRIMARY KEY (id_file);


--
-- Name: pk_komentar; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY komentar
    ADD CONSTRAINT pk_komentar PRIMARY KEY (id_komentar);


--
-- Name: pk_nilai_pekerjaan; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY nilai_pekerjaan
    ADD CONSTRAINT pk_nilai_pekerjaan PRIMARY KEY (id_nilai);


--
-- Name: pk_pekerjaan; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pekerjaan
    ADD CONSTRAINT pk_pekerjaan PRIMARY KEY (id_pekerjaan);


--
-- Name: pk_sifat_pekerjaan; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sifat_pekerjaan
    ADD CONSTRAINT pk_sifat_pekerjaan PRIMARY KEY (id_sifat_pekerjaan);


--
-- Name: pk_tipe_nilai; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tipe_nilai
    ADD CONSTRAINT pk_tipe_nilai PRIMARY KEY (id_tipe_nilai);


--
-- Name: primary key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY detil_progress
    ADD CONSTRAINT "primary key" PRIMARY KEY (id_detil_progress);


--
-- Name: status_pekerjaan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY status_pekerjaan
    ADD CONSTRAINT status_pekerjaan_pkey PRIMARY KEY (id_status_pekerjaan);


--
-- Name: status_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY status
    ADD CONSTRAINT status_pkey PRIMARY KEY (status_id);


--
-- Name: activity_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX activity_pk ON activity USING btree (id_activity);


--
-- Name: detil_pekerjaan_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX detil_pekerjaan_pk ON detil_pekerjaan USING btree (id_detil_pekerjaan);


--
-- Name: file_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX file_pk ON file USING btree (id_file);


--
-- Name: fki_detil_pekerjaan; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_detil_pekerjaan ON nilai_pekerjaan USING btree (id_detil_pekerjaan);


--
-- Name: fki_id_pengaduan; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_id_pengaduan ON pekerjaan USING btree (id_pengaduan);


--
-- Name: fki_tipe_nilai; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_tipe_nilai ON nilai_pekerjaan USING btree (id_tipe_nilai);


--
-- Name: komentar_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX komentar_pk ON komentar USING btree (id_komentar);


--
-- Name: pekerjaan_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX pekerjaan_pk ON pekerjaan USING btree (id_pekerjaan);


--
-- Name: relationship_10_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX relationship_10_fk ON activity USING btree (id_detil_pekerjaan);


--
-- Name: relationship_3_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX relationship_3_fk ON detil_pekerjaan USING btree (id_akun);


--
-- Name: relationship_4_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX relationship_4_fk ON detil_pekerjaan USING btree (id_pekerjaan);


--
-- Name: relationship_5_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX relationship_5_fk ON pekerjaan USING btree (id_sifat_pekerjaan);


--
-- Name: relationship_6_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX relationship_6_fk ON komentar USING btree (id_akun);


--
-- Name: relationship_7_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX relationship_7_fk ON komentar USING btree (id_pekerjaan);


--
-- Name: relationship_8_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX relationship_8_fk ON file USING btree (id_pekerjaan);


--
-- Name: relationship_9_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX relationship_9_fk ON activity USING btree (id_akun);


--
-- Name: sifat_pekerjaan_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX sifat_pekerjaan_pk ON sifat_pekerjaan USING btree (id_sifat_pekerjaan);


--
-- Name: fk_detil_pe_relations_pekerjaa; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY detil_pekerjaan
    ADD CONSTRAINT fk_detil_pe_relations_pekerjaa FOREIGN KEY (id_pekerjaan) REFERENCES pekerjaan(id_pekerjaan) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_detil_pekerjaan; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY nilai_pekerjaan
    ADD CONSTRAINT fk_detil_pekerjaan FOREIGN KEY (id_detil_pekerjaan) REFERENCES detil_pekerjaan(id_detil_pekerjaan);


--
-- Name: fk_file_relations_pekerjaa; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY file
    ADD CONSTRAINT fk_file_relations_pekerjaa FOREIGN KEY (id_pekerjaan) REFERENCES pekerjaan(id_pekerjaan) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_id_pengaduan; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY pekerjaan
    ADD CONSTRAINT fk_id_pengaduan FOREIGN KEY (id_pengaduan) REFERENCES pengaduan(id_pengaduan);


--
-- Name: fk_komentar_relations_pekerjaa; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY komentar
    ADD CONSTRAINT fk_komentar_relations_pekerjaa FOREIGN KEY (id_pekerjaan) REFERENCES pekerjaan(id_pekerjaan) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_pekerjaa_relations_sifat_pe; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY pekerjaan
    ADD CONSTRAINT fk_pekerjaa_relations_sifat_pe FOREIGN KEY (id_sifat_pekerjaan) REFERENCES sifat_pekerjaan(id_sifat_pekerjaan) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_tipe_nilai; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY nilai_pekerjaan
    ADD CONSTRAINT fk_tipe_nilai FOREIGN KEY (id_tipe_nilai) REFERENCES tipe_nilai(id_tipe_nilai);


--
-- Name: foreign key detil pekerjaan; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY detil_progress
    ADD CONSTRAINT "foreign key detil pekerjaan" FOREIGN KEY (id_detil_pekerjaan) REFERENCES detil_pekerjaan(id_detil_pekerjaan);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

