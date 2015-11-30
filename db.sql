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
-- Name: COLUMN pekerjaan.kategori; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN pekerjaan.kategori IS 'rutin
project
tambahan
kreativitas';


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
252	184	2	\N	\N	\N	0	0	\N	1	0	0	0	0	0	0	0	0	0	1	item	bulan
253	184	3	\N	\N	\N	0	0	\N	1	0	0	0	0	0	0	0	0	0	1	item	bulan
254	185	2	\N	\N	\N	0	0	\N	1	0	0	0	0	0	0	0	0	0	1	item	bulan
255	185	3	\N	\N	\N	0	0	\N	1	0	0	0	0	0	0	0	0	0	1	item	bulan
256	186	2	\N	\N	\N	0	0	\N	1	0	0	0	0	0	0	0	0	0	1	item	bulan
257	186	3	\N	\N	\N	0	0	\N	1	0	0	0	0	0	0	0	0	0	1	item	bulan
258	187	2	\N	\N	\N	0	0	\N	1	0	0	0	0	0	0	0	0	0	1	item	bulan
259	187	3	\N	\N	\N	0	0	\N	1	0	0	0	0	0	0	0	0	0	1	item	bulan
260	188	2	\N	\N	\N	0	0	\N	1	0	0	1	0	0	0	0	0	0	1	item	bulan
261	188	3	\N	\N	\N	0	0	\N	1	0	0	1	0	0	0	0	0	0	1	item	bulan
262	189	2	\N	\N	\N	0	0	\N	1	0	0	1	0	0	0	0	0	0	1	item	bulan
263	189	3	\N	\N	\N	0	0	\N	1	0	0	1	0	0	0	0	0	0	1	item	bulan
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
180	1	\N	tambahan1	tambahan2	2015-11-22 00:00:00+07	2015-11-27 00:00:00+07	taskmanagement	1	\N	\N	tambahan	1	\N	7	\N	\N
181	1	\N	kreativitas1	kreativitas1	2015-11-23 00:00:00+07	2015-11-30 00:00:00+07	taskmanagement	1	\N	\N	kreativitas	1	\N	7	\N	1
184	1	\N	pro1	pro1	2015-11-01 00:00:00+07	2015-11-30 00:00:00+07	taskmanagement	1	\N	\N	project	1	\N	7	\N	\N
185	1	\N	pro1	pro1	2015-11-01 00:00:00+07	2015-11-30 00:00:00+07	taskmanagement	1	\N	\N	project	1	\N	7	\N	\N
186	1	\N	pro1	pro1	2015-11-01 00:00:00+07	2015-11-30 00:00:00+07	taskmanagement	1	\N	\N	project	1	\N	7	\N	\N
187	1	\N	pro1	pro1	2015-11-01 00:00:00+07	2015-11-30 00:00:00+07	taskmanagement	1	\N	\N	project	1	\N	7	\N	\N
188	1	\N	pro1	pro1	2015-11-01 00:00:00+07	2015-11-30 00:00:00+07	taskmanagement	1	\N	\N	project	1	\N	7	\N	\N
189	1	\N	pro1	pro1	2015-11-01 00:00:00+07	2015-11-30 00:00:00+07	taskmanagement	1	\N	\N	project	1	\N	7	\N	\N
179	2	\N	skp1	skp1	\N	\N	taskmanagement	1	\N	\N	rutin	1	\N	7	2015	\N
182	1	\N	skp3	aa	\N	\N	taskmanagement	1	\N	\N	rutin	1	\N	7	2015	\N
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

SELECT pg_catalog.setval('tbl_activity_id', 2947, true);


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

SELECT pg_catalog.setval('tbl_detil_pekerjaan_id', 263, true);


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

SELECT pg_catalog.setval('tbl_pekerjaan_id', 189, true);


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

