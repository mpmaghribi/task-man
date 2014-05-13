PGDMP         .                r            taskman    9.3.3    9.3.3 Z               0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                       false                       0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                       false                       1262    67373    taskman    DATABASE     �   CREATE DATABASE taskman WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'English_United Kingdom.1252' LC_CTYPE = 'English_United Kingdom.1252';
    DROP DATABASE taskman;
             postgres    false                        2615    2200    public    SCHEMA        CREATE SCHEMA public;
    DROP SCHEMA public;
             postgres    false                       0    0    SCHEMA public    COMMENT     6   COMMENT ON SCHEMA public IS 'standard public schema';
                  postgres    false    6                       0    0    public    ACL     �   REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;
                  postgres    false    6            �            3079    11750    plpgsql 	   EXTENSION     ?   CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;
    DROP EXTENSION plpgsql;
                  false                       0    0    EXTENSION plpgsql    COMMENT     @   COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';
                       false    190            �            1255    67374 4   function_login(character varying, character varying)    FUNCTION     �  CREATE FUNCTION function_login(f_username character varying, f_pwd character varying) RETURNS record
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
 \   DROP FUNCTION public.function_login(f_username character varying, f_pwd character varying);
       public       postgres    false    6    190            �            1255    67375 �   function_register(integer, integer, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying)    FUNCTION     )  CREATE FUNCTION function_register(f_jabatan integer, f_departemen integer, f_nip character varying, f_nama character varying, f_alamat character varying, f_gender character varying, f_agama character varying, f_homephone character varying, f_mobilephone character varying, f_email character varying, f_password character varying) RETURNS record
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
 P  DROP FUNCTION public.function_register(f_jabatan integer, f_departemen integer, f_nip character varying, f_nama character varying, f_alamat character varying, f_gender character varying, f_agama character varying, f_homephone character varying, f_mobilephone character varying, f_email character varying, f_password character varying);
       public       postgres    false    6    190            �            1255    67376 1   function_tambah_detil_pekerjaan(integer, integer)    FUNCTION     �  CREATE FUNCTION function_tambah_detil_pekerjaan(f_id_pekerjaan_baru integer, f_id_akun integer) RETURNS record
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
 f   DROP FUNCTION public.function_tambah_detil_pekerjaan(f_id_pekerjaan_baru integer, f_id_akun integer);
       public       postgres    false    190    6            �            1255    67377 �   function_tambah_pkj(integer, integer, character varying, character varying, date, date, character varying, character varying, integer)    FUNCTION     �  CREATE FUNCTION function_tambah_pkj(f_id_sifat_pkj integer, f_parent_pkj integer, f_nama_pkj character varying, f_deskripsi_pkj character varying, f_tgl_mulai date, f_tgl_selesai date, f_status_pkj character varying, f_asal_pkj character varying, f_prioritas_pkj integer) RETURNS record
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
   DROP FUNCTION public.function_tambah_pkj(f_id_sifat_pkj integer, f_parent_pkj integer, f_nama_pkj character varying, f_deskripsi_pkj character varying, f_tgl_mulai date, f_tgl_selesai date, f_status_pkj character varying, f_asal_pkj character varying, f_prioritas_pkj integer);
       public       postgres    false    190    6            �            1255    67378    tes(integer)    FUNCTION     s   CREATE FUNCTION tes(angka integer) RETURNS integer
    LANGUAGE plpgsql
    AS $$begin
	return angka +100;
end;$$;
 )   DROP FUNCTION public.tes(angka integer);
       public       postgres    false    6    190            �            1259    67379    tbl_activity_id    SEQUENCE     q   CREATE SEQUENCE tbl_activity_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.tbl_activity_id;
       public       postgres    false    6            �            1259    67381    activity    TABLE       CREATE TABLE activity (
    id_activity integer DEFAULT nextval('tbl_activity_id'::regclass) NOT NULL,
    id_akun integer,
    id_detil_pekerjaan integer,
    nama_activity character varying(50),
    deskripsi_activity text,
    tanggal_activity timestamp with time zone
);
    DROP TABLE public.activity;
       public         postgres    false    170    6            �            1259    67388 	   consignee    TABLE     �   CREATE TABLE consignee (
    id_tableconsignee integer NOT NULL,
    id_akun integer NOT NULL,
    id_pekerjaan integer NOT NULL
);
    DROP TABLE public.consignee;
       public         postgres    false    6            �            1259    67391    tbl_departemen_id    SEQUENCE     s   CREATE SEQUENCE tbl_departemen_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.tbl_departemen_id;
       public       postgres    false    6            �            1259    67393 
   departemen    TABLE     �   CREATE TABLE departemen (
    id_departemen integer DEFAULT nextval('tbl_departemen_id'::regclass) NOT NULL,
    nama_departemen character varying(50)
);
    DROP TABLE public.departemen;
       public         postgres    false    173    6            �            1259    67397    tbl_detil_pekerjaan_id    SEQUENCE     �   CREATE SEQUENCE tbl_detil_pekerjaan_id
    START WITH 25
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;
 -   DROP SEQUENCE public.tbl_detil_pekerjaan_id;
       public       postgres    false    6            �            1259    67399    detil_pekerjaan    TABLE     =  CREATE TABLE detil_pekerjaan (
    id_detil_pekerjaan integer DEFAULT nextval('tbl_detil_pekerjaan_id'::regclass) NOT NULL,
    id_pekerjaan integer,
    id_akun integer,
    tgl_read date,
    tglasli_mulai date,
    tglasli_selesai date,
    skor integer,
    progress integer,
    status character varying(100)
);
 #   DROP TABLE public.detil_pekerjaan;
       public         postgres    false    175    6            �            1259    67403    tbl_file_id    SEQUENCE     m   CREATE SEQUENCE tbl_file_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 "   DROP SEQUENCE public.tbl_file_id;
       public       postgres    false    6            �            1259    67405    file    TABLE     �   CREATE TABLE file (
    id_file integer DEFAULT nextval('tbl_file_id'::regclass) NOT NULL,
    id_pekerjaan integer,
    nama_file character varying(100)
);
    DROP TABLE public.file;
       public         postgres    false    177    6            �            1259    67409    tbl_jabatan_id    SEQUENCE     p   CREATE SEQUENCE tbl_jabatan_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.tbl_jabatan_id;
       public       postgres    false    6            �            1259    67411    jabatan    TABLE     �   CREATE TABLE jabatan (
    id_jabatan integer DEFAULT nextval('tbl_jabatan_id'::regclass) NOT NULL,
    nama_jabatan character varying(50)
);
    DROP TABLE public.jabatan;
       public         postgres    false    179    6            �            1259    67415    tbl_komentar_id    SEQUENCE     q   CREATE SEQUENCE tbl_komentar_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.tbl_komentar_id;
       public       postgres    false    6            �            1259    67417    komentar    TABLE     �   CREATE TABLE komentar (
    id_komentar integer DEFAULT nextval('tbl_komentar_id'::regclass) NOT NULL,
    id_akun integer,
    id_pekerjaan integer,
    isi_komentar text,
    tgl_komentar timestamp with time zone,
    history_komentar text
);
    DROP TABLE public.komentar;
       public         postgres    false    181    6            �            1259    67424    tbl_pekerjaan_id    SEQUENCE     |   CREATE SEQUENCE tbl_pekerjaan_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;
 '   DROP SEQUENCE public.tbl_pekerjaan_id;
       public       postgres    false    6            �            1259    67426 	   pekerjaan    TABLE     �  CREATE TABLE pekerjaan (
    id_pekerjaan integer DEFAULT nextval('tbl_pekerjaan_id'::regclass) NOT NULL,
    id_sifat_pekerjaan integer,
    parent_pekerjaan integer,
    nama_pekerjaan character varying(2000),
    deskripsi_pekerjaan text,
    tgl_mulai date,
    tgl_selesai date,
    asal_pekerjaan character varying(50),
    level_prioritas integer,
    flag_usulan character varying
);
    DROP TABLE public.pekerjaan;
       public         postgres    false    183    6            �            1259    67433    pemberi_pekerjaan    TABLE     �   CREATE TABLE pemberi_pekerjaan (
    id_tablepk integer NOT NULL,
    id_pekerjaan integer NOT NULL,
    id_akun integer NOT NULL
);
 %   DROP TABLE public.pemberi_pekerjaan;
       public         postgres    false    6            �            1259    67436 	   previlege    TABLE     i   CREATE TABLE previlege (
    id_previlege integer NOT NULL,
    nama_previlege character varying(100)
);
    DROP TABLE public.previlege;
       public         postgres    false    6            �            1259    67439    tbl_sifat_pkj_id    SEQUENCE     r   CREATE SEQUENCE tbl_sifat_pkj_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.tbl_sifat_pkj_id;
       public       postgres    false    6            �            1259    67441    sifat_pekerjaan    TABLE     �   CREATE TABLE sifat_pekerjaan (
    id_sifat_pekerjaan integer DEFAULT nextval('tbl_sifat_pkj_id'::regclass) NOT NULL,
    nama_sifat_pekerjaan character varying(50)
);
 #   DROP TABLE public.sifat_pekerjaan;
       public         postgres    false    187    6            �            1259    67445    tbl_akun_id    SEQUENCE     l   CREATE SEQUENCE tbl_akun_id
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    NO MAXVALUE
    CACHE 1;
 "   DROP SEQUENCE public.tbl_akun_id;
       public       postgres    false    6                      0    67381    activity 
   TABLE DATA               z   COPY activity (id_activity, id_akun, id_detil_pekerjaan, nama_activity, deskripsi_activity, tanggal_activity) FROM stdin;
    public       postgres    false    171   �m                 0    67388 	   consignee 
   TABLE DATA               F   COPY consignee (id_tableconsignee, id_akun, id_pekerjaan) FROM stdin;
    public       postgres    false    172   �                 0    67393 
   departemen 
   TABLE DATA               =   COPY departemen (id_departemen, nama_departemen) FROM stdin;
    public       postgres    false    174   �                 0    67399    detil_pekerjaan 
   TABLE DATA               �   COPY detil_pekerjaan (id_detil_pekerjaan, id_pekerjaan, id_akun, tgl_read, tglasli_mulai, tglasli_selesai, skor, progress, status) FROM stdin;
    public       postgres    false    176   L�       
          0    67405    file 
   TABLE DATA               9   COPY file (id_file, id_pekerjaan, nama_file) FROM stdin;
    public       postgres    false    178   �                 0    67411    jabatan 
   TABLE DATA               4   COPY jabatan (id_jabatan, nama_jabatan) FROM stdin;
    public       postgres    false    180   .�                 0    67417    komentar 
   TABLE DATA               m   COPY komentar (id_komentar, id_akun, id_pekerjaan, isi_komentar, tgl_komentar, history_komentar) FROM stdin;
    public       postgres    false    182   m�                 0    67426 	   pekerjaan 
   TABLE DATA               �   COPY pekerjaan (id_pekerjaan, id_sifat_pekerjaan, parent_pekerjaan, nama_pekerjaan, deskripsi_pekerjaan, tgl_mulai, tgl_selesai, asal_pekerjaan, level_prioritas, flag_usulan) FROM stdin;
    public       postgres    false    184   ?�                 0    67433    pemberi_pekerjaan 
   TABLE DATA               G   COPY pemberi_pekerjaan (id_tablepk, id_pekerjaan, id_akun) FROM stdin;
    public       postgres    false    185   ��                 0    67436 	   previlege 
   TABLE DATA               :   COPY previlege (id_previlege, nama_previlege) FROM stdin;
    public       postgres    false    186   ��                 0    67441    sifat_pekerjaan 
   TABLE DATA               L   COPY sifat_pekerjaan (id_sifat_pekerjaan, nama_sifat_pekerjaan) FROM stdin;
    public       postgres    false    188   є                  0    0    tbl_activity_id    SEQUENCE SET     8   SELECT pg_catalog.setval('tbl_activity_id', 781, true);
            public       postgres    false    170                       0    0    tbl_akun_id    SEQUENCE SET     2   SELECT pg_catalog.setval('tbl_akun_id', 4, true);
            public       postgres    false    189                        0    0    tbl_departemen_id    SEQUENCE SET     8   SELECT pg_catalog.setval('tbl_departemen_id', 5, true);
            public       postgres    false    173            !           0    0    tbl_detil_pekerjaan_id    SEQUENCE SET     >   SELECT pg_catalog.setval('tbl_detil_pekerjaan_id', 66, true);
            public       postgres    false    175            "           0    0    tbl_file_id    SEQUENCE SET     3   SELECT pg_catalog.setval('tbl_file_id', 28, true);
            public       postgres    false    177            #           0    0    tbl_jabatan_id    SEQUENCE SET     5   SELECT pg_catalog.setval('tbl_jabatan_id', 3, true);
            public       postgres    false    179            $           0    0    tbl_komentar_id    SEQUENCE SET     7   SELECT pg_catalog.setval('tbl_komentar_id', 98, true);
            public       postgres    false    181            %           0    0    tbl_pekerjaan_id    SEQUENCE SET     8   SELECT pg_catalog.setval('tbl_pekerjaan_id', 80, true);
            public       postgres    false    183            &           0    0    tbl_sifat_pkj_id    SEQUENCE SET     8   SELECT pg_catalog.setval('tbl_sifat_pkj_id', 1, false);
            public       postgres    false    187            i           2606    67448    pk_activity 
   CONSTRAINT     T   ALTER TABLE ONLY activity
    ADD CONSTRAINT pk_activity PRIMARY KEY (id_activity);
 >   ALTER TABLE ONLY public.activity DROP CONSTRAINT pk_activity;
       public         postgres    false    171    171            r           2606    67450    pk_departemen 
   CONSTRAINT     Z   ALTER TABLE ONLY departemen
    ADD CONSTRAINT pk_departemen PRIMARY KEY (id_departemen);
 B   ALTER TABLE ONLY public.departemen DROP CONSTRAINT pk_departemen;
       public         postgres    false    174    174            u           2606    67452    pk_detil_pekerjaan 
   CONSTRAINT     i   ALTER TABLE ONLY detil_pekerjaan
    ADD CONSTRAINT pk_detil_pekerjaan PRIMARY KEY (id_detil_pekerjaan);
 L   ALTER TABLE ONLY public.detil_pekerjaan DROP CONSTRAINT pk_detil_pekerjaan;
       public         postgres    false    176    176            z           2606    67454    pk_file 
   CONSTRAINT     H   ALTER TABLE ONLY file
    ADD CONSTRAINT pk_file PRIMARY KEY (id_file);
 6   ALTER TABLE ONLY public.file DROP CONSTRAINT pk_file;
       public         postgres    false    178    178            o           2606    67456    pk_id_consignee 
   CONSTRAINT     _   ALTER TABLE ONLY consignee
    ADD CONSTRAINT pk_id_consignee PRIMARY KEY (id_tableconsignee);
 C   ALTER TABLE ONLY public.consignee DROP CONSTRAINT pk_id_consignee;
       public         postgres    false    172    172            �           2606    67458    pk_id_previlege 
   CONSTRAINT     Z   ALTER TABLE ONLY previlege
    ADD CONSTRAINT pk_id_previlege PRIMARY KEY (id_previlege);
 C   ALTER TABLE ONLY public.previlege DROP CONSTRAINT pk_id_previlege;
       public         postgres    false    186    186            �           2606    67460    pk_id_tablepk 
   CONSTRAINT     ^   ALTER TABLE ONLY pemberi_pekerjaan
    ADD CONSTRAINT pk_id_tablepk PRIMARY KEY (id_tablepk);
 I   ALTER TABLE ONLY public.pemberi_pekerjaan DROP CONSTRAINT pk_id_tablepk;
       public         postgres    false    185    185            ~           2606    67462 
   pk_jabatan 
   CONSTRAINT     Q   ALTER TABLE ONLY jabatan
    ADD CONSTRAINT pk_jabatan PRIMARY KEY (id_jabatan);
 <   ALTER TABLE ONLY public.jabatan DROP CONSTRAINT pk_jabatan;
       public         postgres    false    180    180            �           2606    67464    pk_komentar 
   CONSTRAINT     T   ALTER TABLE ONLY komentar
    ADD CONSTRAINT pk_komentar PRIMARY KEY (id_komentar);
 >   ALTER TABLE ONLY public.komentar DROP CONSTRAINT pk_komentar;
       public         postgres    false    182    182            �           2606    67466    pk_pekerjaan 
   CONSTRAINT     W   ALTER TABLE ONLY pekerjaan
    ADD CONSTRAINT pk_pekerjaan PRIMARY KEY (id_pekerjaan);
 @   ALTER TABLE ONLY public.pekerjaan DROP CONSTRAINT pk_pekerjaan;
       public         postgres    false    184    184            �           2606    67468    pk_sifat_pekerjaan 
   CONSTRAINT     i   ALTER TABLE ONLY sifat_pekerjaan
    ADD CONSTRAINT pk_sifat_pekerjaan PRIMARY KEY (id_sifat_pekerjaan);
 L   ALTER TABLE ONLY public.sifat_pekerjaan DROP CONSTRAINT pk_sifat_pekerjaan;
       public         postgres    false    188    188            g           1259    67469    activity_pk    INDEX     G   CREATE UNIQUE INDEX activity_pk ON activity USING btree (id_activity);
    DROP INDEX public.activity_pk;
       public         postgres    false    171            p           1259    67470    departemen_pk    INDEX     M   CREATE UNIQUE INDEX departemen_pk ON departemen USING btree (id_departemen);
 !   DROP INDEX public.departemen_pk;
       public         postgres    false    174            s           1259    67471    detil_pekerjaan_pk    INDEX     \   CREATE UNIQUE INDEX detil_pekerjaan_pk ON detil_pekerjaan USING btree (id_detil_pekerjaan);
 &   DROP INDEX public.detil_pekerjaan_pk;
       public         postgres    false    176            x           1259    67472    file_pk    INDEX     ;   CREATE UNIQUE INDEX file_pk ON file USING btree (id_file);
    DROP INDEX public.file_pk;
       public         postgres    false    178            l           1259    67473    fki_id_akun    INDEX     =   CREATE INDEX fki_id_akun ON consignee USING btree (id_akun);
    DROP INDEX public.fki_id_akun;
       public         postgres    false    172            �           1259    67474    fki_id_akun2    INDEX     F   CREATE INDEX fki_id_akun2 ON pemberi_pekerjaan USING btree (id_akun);
     DROP INDEX public.fki_id_akun2;
       public         postgres    false    185            m           1259    67475    fki_id_pekerjaan    INDEX     G   CREATE INDEX fki_id_pekerjaan ON consignee USING btree (id_pekerjaan);
 $   DROP INDEX public.fki_id_pekerjaan;
       public         postgres    false    172            �           1259    67476    fki_id_pekerjaan2    INDEX     P   CREATE INDEX fki_id_pekerjaan2 ON pemberi_pekerjaan USING btree (id_pekerjaan);
 %   DROP INDEX public.fki_id_pekerjaan2;
       public         postgres    false    185            |           1259    67477 
   jabatan_pk    INDEX     D   CREATE UNIQUE INDEX jabatan_pk ON jabatan USING btree (id_jabatan);
    DROP INDEX public.jabatan_pk;
       public         postgres    false    180                       1259    67478    komentar_pk    INDEX     G   CREATE UNIQUE INDEX komentar_pk ON komentar USING btree (id_komentar);
    DROP INDEX public.komentar_pk;
       public         postgres    false    182            �           1259    67479    pekerjaan_pk    INDEX     J   CREATE UNIQUE INDEX pekerjaan_pk ON pekerjaan USING btree (id_pekerjaan);
     DROP INDEX public.pekerjaan_pk;
       public         postgres    false    184            j           1259    67480    relationship_10_fk    INDEX     N   CREATE INDEX relationship_10_fk ON activity USING btree (id_detil_pekerjaan);
 &   DROP INDEX public.relationship_10_fk;
       public         postgres    false    171            v           1259    67481    relationship_3_fk    INDEX     I   CREATE INDEX relationship_3_fk ON detil_pekerjaan USING btree (id_akun);
 %   DROP INDEX public.relationship_3_fk;
       public         postgres    false    176            w           1259    67482    relationship_4_fk    INDEX     N   CREATE INDEX relationship_4_fk ON detil_pekerjaan USING btree (id_pekerjaan);
 %   DROP INDEX public.relationship_4_fk;
       public         postgres    false    176            �           1259    67483    relationship_5_fk    INDEX     N   CREATE INDEX relationship_5_fk ON pekerjaan USING btree (id_sifat_pekerjaan);
 %   DROP INDEX public.relationship_5_fk;
       public         postgres    false    184            �           1259    67484    relationship_6_fk    INDEX     B   CREATE INDEX relationship_6_fk ON komentar USING btree (id_akun);
 %   DROP INDEX public.relationship_6_fk;
       public         postgres    false    182            �           1259    67485    relationship_7_fk    INDEX     G   CREATE INDEX relationship_7_fk ON komentar USING btree (id_pekerjaan);
 %   DROP INDEX public.relationship_7_fk;
       public         postgres    false    182            {           1259    67486    relationship_8_fk    INDEX     C   CREATE INDEX relationship_8_fk ON file USING btree (id_pekerjaan);
 %   DROP INDEX public.relationship_8_fk;
       public         postgres    false    178            k           1259    67487    relationship_9_fk    INDEX     B   CREATE INDEX relationship_9_fk ON activity USING btree (id_akun);
 %   DROP INDEX public.relationship_9_fk;
       public         postgres    false    171            �           1259    67488    sifat_pekerjaan_pk    INDEX     \   CREATE UNIQUE INDEX sifat_pekerjaan_pk ON sifat_pekerjaan USING btree (id_sifat_pekerjaan);
 &   DROP INDEX public.sifat_pekerjaan_pk;
       public         postgres    false    188            �           2606    67489    fk_detil_pe_relations_pekerjaa    FK CONSTRAINT     �   ALTER TABLE ONLY detil_pekerjaan
    ADD CONSTRAINT fk_detil_pe_relations_pekerjaa FOREIGN KEY (id_pekerjaan) REFERENCES pekerjaan(id_pekerjaan) ON UPDATE RESTRICT ON DELETE RESTRICT;
 X   ALTER TABLE ONLY public.detil_pekerjaan DROP CONSTRAINT fk_detil_pe_relations_pekerjaa;
       public       postgres    false    176    184    1926            �           2606    67494    fk_file_relations_pekerjaa    FK CONSTRAINT     �   ALTER TABLE ONLY file
    ADD CONSTRAINT fk_file_relations_pekerjaa FOREIGN KEY (id_pekerjaan) REFERENCES pekerjaan(id_pekerjaan) ON UPDATE RESTRICT ON DELETE RESTRICT;
 I   ALTER TABLE ONLY public.file DROP CONSTRAINT fk_file_relations_pekerjaa;
       public       postgres    false    178    184    1926            �           2606    67499    fk_id_pekerjaan    FK CONSTRAINT     }   ALTER TABLE ONLY consignee
    ADD CONSTRAINT fk_id_pekerjaan FOREIGN KEY (id_pekerjaan) REFERENCES pekerjaan(id_pekerjaan);
 C   ALTER TABLE ONLY public.consignee DROP CONSTRAINT fk_id_pekerjaan;
       public       postgres    false    172    184    1926            �           2606    67504    fk_id_pekerjaan2    FK CONSTRAINT     �   ALTER TABLE ONLY pemberi_pekerjaan
    ADD CONSTRAINT fk_id_pekerjaan2 FOREIGN KEY (id_pekerjaan) REFERENCES pekerjaan(id_pekerjaan);
 L   ALTER TABLE ONLY public.pemberi_pekerjaan DROP CONSTRAINT fk_id_pekerjaan2;
       public       postgres    false    184    1926    185            �           2606    67509    fk_komentar_relations_pekerjaa    FK CONSTRAINT     �   ALTER TABLE ONLY komentar
    ADD CONSTRAINT fk_komentar_relations_pekerjaa FOREIGN KEY (id_pekerjaan) REFERENCES pekerjaan(id_pekerjaan) ON UPDATE RESTRICT ON DELETE RESTRICT;
 Q   ALTER TABLE ONLY public.komentar DROP CONSTRAINT fk_komentar_relations_pekerjaa;
       public       postgres    false    184    1926    182            �           2606    67514    fk_pekerjaa_relations_sifat_pe    FK CONSTRAINT     �   ALTER TABLE ONLY pekerjaan
    ADD CONSTRAINT fk_pekerjaa_relations_sifat_pe FOREIGN KEY (id_sifat_pekerjaan) REFERENCES sifat_pekerjaan(id_sifat_pekerjaan) ON UPDATE RESTRICT ON DELETE RESTRICT;
 R   ALTER TABLE ONLY public.pekerjaan DROP CONSTRAINT fk_pekerjaa_relations_sifat_pe;
       public       postgres    false    1935    184    188                  x��][��q~���%O���=/A��1�A��r���#��3�/�>uck|8�4yXm`����|M6�X�������~|����积���Χ����bï��+�N���t�$c��%��<N��xw�I9�cq�c�d�͒�1W|,�|,� `��/�����?޽;?ߝ�p{�������ӗ�/�����w��O���_��O�R��ۧ�w�ϧ��_?�_|�|w~�;=��?��v�У7k]��.7>�F�^��^ok�B�����v��Ƕ�pl�����9��dA�_����Q����Ư ���v�pAɇ�@���k�?�������EKϥ�����h2K��;��7q5K�-;�@iXx�ؔ蹵>����?>��<郉�V薝oJ��z���� :�����]Ǯ>�ɖ��=��&$<m��74q0%�wq����F8�?�K��sxk�H��w�n�ٰ�,���yp�9�A��uߋ╸��t]�~����i@�'<�q�v�{�c���z��[��M&{}��,q{n5��sa�.1�z��]ʦ>l*�MڽFG_������R7��7��1&�)؍ؠ�@��5RHF�aW���L�/v�36�do���!v�oب�� vGc��g�>�l`lЫ��l��p8�5K ��PlP�����`q�F
��1�3���p�VC� �&���j����2��j50���|�E���.<4�-߲q�5��o�MFZ4���rB�����=���M�lc���	^b���Q���5�}�x�.��vq��U�<'�W�����+8��y�0��"ZT���t����=�>X��`�����b~Σ��mu��17zŶ��,8~�cn����$��c��%6��&�1r���9�yN���l��ِIo;�;��G���U|b���ۇ/��~��������}�ۋ��������W�\V�OB��+~�}K�d{���p� ����M,�q�;�+~(b�&s("��~�1/KKW�Њ*r��C�"ݱ�9�y�����7ZX䷃.�\F�>��j�u�x4�bĘ[t$�e���1jݍ[����q��y�&1��U-��f@���G������S|ϓd>w%�<Y�m#?w?��pE�\�AI������ݗ��7�7O���ۇwO��OϷ�����t�=��;}8<"��������;�"c`/�������~��݇�ӻ�/经���$�o:�+p1��P)��^���o~��Q;�����.h䮁�q]��>?=��}~�\����y[�k�ф�N�j���S�!�r�øC�V&ëW^o<��kP=)`�c\f5���5�k���"���W=V[�o��y�I�[�E�G�l�D��z�yfml��Z�\��)~�q����\.5�,��Xi��R�́�^R��5b��Z�;�T�r�B�`�@�"��RoL��#[�i#vQ�	��R��Za�ܣ�u\��9��4.��Ps���)�^Y1��7�����M��Uc�"`U�0�_D>����S�qE֡"��q�Z�*��Eԕw,VA̭�9��B���ԅg���[J��:AA�-&�c��7��0<���R���0��Z�NA�-���T%QVNA�-�h�)��Srb;�S�E!:)GZ�7�1�˩H�%_Ɖ�u*R�:1���7W�r�\�zvU��9ܫ���U��a���Ć�W�soF�p0U��av�x�s�"�.#!�$ֻ^E�֑�\y9w� '���+ȹ��b��B��"��U��� �j���rvu���8)�a�'�]���GB1ꕪ���̣�)�(�U�����&!�:p�߆��_0�ό�"�]��2l��$M�⋳5(a�_,G��K�3#���%o.h����Aֵ3�ؿ.�i<��mC�6��Kp��4�%'�p���Dp5r�����}Ɉ�BE�m���2Dg-z����ۻb��t���'?�����.jr
}�U*c�n�Le:S8�eS_f���%����[��g�GM_c��Tw%��F\���횔�g&�5��Jj`�W�'i��Z��e�ϳ.R��b�`��3>�Z��U N��$vRR9t�l1�sJ���TL'd�Ԯꈱ6=��
�'p��L+��Dq�����]"��I6�:��P��d1?�|����%���U ٥�遬s ND!���g*�Ǌ)����f���T��uw(���µ���j�Y7����Πaq�l��u�0!�q`�(���Y�Y��a؜Xq*�x:�}0�D%���8 ��F��h'Ͱ�c0�v�{p"���+��AO�O� �p��#<,��LqC#����ep����5�����u���z#�HX9p�~!u�n,U���W���w}ja �1�F�qvZq�@���k���>�����װg�ص�q]C	���-�j��5��i8���x����8�2t�5�{���ߡ�>�8�_sZ�ߞ���|�������O,�'� Gn~�1"V-di�2�&X1b4��YS3|y���F�H �U���k��p1 ���5���Z��˗�Sˬ�;�#x��@A`k�5ŀ�C�8'8ci���#c2�/��؅�D8:�R�r��K����ww�����P�'ͫ��<�u�7�?����_�>^���o{�t������û��;�
F}Ej�!�k��u|�9tR�V�@̶��汐���tz!cL0E+����dQ<�pG���{T8���I��p�-ƒ���YwT���I���"�,^���sQq��T�!'jl0R������t<O���E�4�L��b� �����2i���2�|<�ƹ�\Cl�ʴ�+M���������)�_���m��������ׇ/_�AP��O_Ο~>����BQ>pÂ����˘\È����*\��v��)�~�)��L��8����d<�LlS���5��x�D0_�~�
(�&��p�R�0��5�J� F���װ,��eb�2�5��	�a�*���]ò�t��J/�JY�$)��Q��*���A_��X�mTW% .��
��*�2�Eh�N&�1/-Sz\'#r�����U�$���q���ɐË�3��l��������P���!c"��X�4L��x!RJ~��7�^�G��Z�Ws��&:Z0�$j�`�J�Z���
���`<ws*.�����Ip�B.Y���I���0�ȳ)�B�e��+��N��[q0�`�y5v��q�� АL�j���]+E�Li�I���Ä��8v'�x/Q�U���t�Ꮧ�Ib7���<J��Ң�u��� yp4,QP��_�l���~�m�!UE����$��f4�V	zt2L�A�e�r��P'(�}Z6���?�+�%�;JF��ĶE@��H ��Bd���:�}@9�7�$��b�8�tz�F��*&B'��
P�x��zh,[X�\f��H~�χ���*��29/�A���z+k�d"��!!0�Meh�[��U�:rr�V��QSTb9��M��T4v7B��zV?}���V��/�$����������Ff�
��q<��r��0A���n�����H���R���Y�X��m�v/Õ�ߐ��q%�W�uaU�J���Ȁ_T�IA�q
�w2*Gׅ�ٜ	�����Y���;�ɨ��/2��0#�:*�7�[�/��o�=e��_��(ER	���;��b�F�^�AˠDw�FA~zΕ��R���˻|'{v�4��q��#��@�8�o��5��02p1YF^6;�V�1g�
������|Az�`��a9�RaP���k����~�kG�A�%,1�����{���c��;f� #�ԋ�k�|'��Zd��QȎ)�!d�Co��n��.4�:�p�λK��u�7�O��_	�\��P0/�D&w�0h����7�9��GY�����bB�4^�쾣�0Re������0�� T&8_�LW	�z��ed��A�|3ó��j�u�]į��Հ@d�4�)��6V䘧��~T0
͝���J\�    ������V��S��iu���ԫ��.r�Ӈ�X��?O�Xe`��%�Ȳ��+�|�ϣ1.[?[����Q��y�z��48r�7�"���ynZ��܄��/�}��)+��	u�K�"����8�ϟ8�M��D+7��v��7$lѿ�b���JI���v��~ÃI��R��Cuj,���l�D�d���%b��r�d�^����GE"�!r�*
��B�
�Ӵ���N^�u�8V��L�N�����WBȝ��k�#�<��w�Y�Cvh�ʄ�uC��	I�|�������r�9�������1�HM/� OnQ 	�\����^�VW�,-��� �uL+>� �uyŐF�I�~�;��}���@m�q�P�� It٣琸��qǐ-���Qi�+�� 7������*c>����Ӈ���铋F�߫�!� g��l!wE�u��/�}B+=͗E7��1���(�"�g�}!bks�_i�7�{�%P�������0�j@�(�Dr� ΖMq�X�d~�7�y��x8�W�Ae�zϵ�~p�{_��a0t���%0��w�b�B/08��[$M�٠�Z̳�@}����l�:�簵R͡�� )\�g7m���g׺�c�bF��z�rZ�lx8�:�n*�2^��YYb�����#ş�F�x����)v'8ʕ����#x�?��O]�`]C0���Q�hN��*�D��B0�Y�a�2݅A丨knK�N_�`#�b:�����qk�(ur'��^�A�-�a��bwz�{�Q-[�ao^�5~��ۧ���nY�~�ap�%�d���' c�E�k����'uq�p�/쭾���H�L�|X���#Q�z��:cs�Ϯ'�v4G�ް͌,^\�T*�-'� �vp�9�Fi�Z[����x��]x4�Y�tm���M�c�q?w)
�]]�Q�����	��'�����(V��^��]�́��D�!<S��#��y��'"W�e6�F�'�=7��x�x�F{�ǳDZ-)�2#m�̬�j�>3ҥ���=xS�2� �ː�aL���E�����*%��CML�{;�^-���	+8;l��mq:A���]x��쥌Ͱ�b�s�_�˭�P`��+p�˷6��/0w2�#�Bp*&�����廂; eif�t`{;�O#Oe��y?ao����ѹ+zo���#ME��c�蛛������ig�aȸ���a/yp��R���V�;����*A~Kd��ʗ�i�iZ��X0	��n*=T�+7���P6U�Ne�]��R�j���գ��6np��ī���V�� ���ao������g9Sin��͕D"hŴ�B�I�pq�@uߒ2\3l=���%zX��g���$_p��p�VD�ّD��X1V�� �����z�9�#&Hd]{��� ^�\�j���B�o���>*U�`b=#7�މ%3�)������~v�"0+V6�:�T�X��Υ�V���A�K�-��"ǰw�Č����f���-{���1q��ל��-^���Z�ю�	��b�c�c'�$��&�n��]�����&]/YB|�|;"�d�,��޽C&��v������+%�ʶ��1N\���i4ڶw?���JBQ)ʷ��z�TG��r�-B�q�$Q'kzl��.A	{��s������N�S9'�-�z2JĨ�&݁c�M��|@;��=8�:�0�� jA���
�g:!�1�{l����w�	�'8��1�8څQf7�a�݆�e%�~���7
Ǽ�r�yL�$��H4�H�Q�A�0%8j��Q��(��
|`�&3Ncc��@��.#��-}y"�x�����[�ٺ���|�8HX�59a�A�dQ����fjT�TӨ�x��,̸�Zw�U���.4� S�U�Naaa䈏"G$l��Q�z2��xh{l��Sn9�𶎷��ԥ^)��L���-|Ǿ �K��Y<�Ŕ�f��;F�"H
�7�2�zA-Z�QV�7g{-��ܹ;�&h������&�݋�8iͲ��M�tE+g��&q�5o��b�O��D�I!����/��K�3E��:2�f��٘;��7���������q1N��CM�dn_���[A�� .E�&�pH5�_�C�0 ��p���9�,�h�V��Vl�]�d�y�j��9��p
/%��_M���<�E��w6JT�70L������M p�'"��ō{Y����R��X���p�)��5�^r�U:�@�3+]�^n�5��ǎ+��^^��p�����U��y�x���%��.�J5p[�ɫ()�ua�,�)�Q55�x�#������8��ެQ�h��y"�qۡ8:Cw/V�'���w��08?}?~�	��p�埞nN�s�<��O������������oZ�X8���,U���0�I��f�&�|�I)�����@���\m����T�|t��m,��-MO�#���jK��r�6�ă��V�j3�8�նCa���Srb�ݱl
o.Q鲑���^k�����-(�7��ۇ����w�p[�|�tZ����x�|�3���=��^�3<�|���t~��3u���?���o�"�k���K?�9�?�ɠe��iu��`���v0�/A��q�K�z7ȶ���.?-����_^|��\\���+�$�:����z�Q��	�&��Ƿj����F:l8&Z_��z��xq[Gt���IJMu�A�Ü�(��wΘ!��hqyY��M=��'��k��,Xx({T�pV�y�r@Tk5\�$.��O~� P�k�Dvg���Ҝ����¬Á�f况�)(;��>�����U��;0��?ݾ�
O�{2���_�k�R����M��<.c�����Ğ���A�XɁ��m���Y^�����P���`��ܖ���-���<*��=FD��k�n�pAx�uT���@LpFy}�|82A����%�J�,Q�K�� g�q��Vs����"��Z$Y�J��#���[�Ć�;UWb/S���5�FBh�4��yVu����-}�`���п��tlS<��p��"L�j��
�#��cC�sHȂY8h�{�mf�c���j���5O�.�e�������ڮ���X���ik3^������ڮ��
�a�Z*��+f<2�ŗH���	�-<���4��E<.%�vj�b��Џ�\�T;i2ŭl���6ҫx�{������a��ԕ��t89�T�MW<P.�}ɤږ��ak�x�����-���*�ϵ%R%�v�E�%���\�"d1�=�4J���Á��>U&/�Q%��J�D��LC�9��F9�x�+�ȘT��0�d}�څ2�+�`�`�����s�e"�6W�x�[Bu6 �%j}��~���@,a��Q:o5�.�K�T�1��*�#�rM��!|�۝��N
��FB�L�T�.<�!]e?��Nr)�1�.�vz�hҫw��.��X ���������'�/!9�cE����+�7�UV9'��6d�,R�,Ղ���C�!�jA��)y�n� ��\�T���͹m�A'��'�yj&7�j�D��n��|.�6c��� /�jJ��VJ�r�!�R�	��B:�����x��9/��p�s F�%X8�d����H-TR��y��I���AJp��W�*O��0��cJ_��s\6XO� %<$[3q*6����+��I����%����:��F�(Qf��W�;Kx�dp��#�*����b ���z�&�Rq���P��|"��,�էj%	�E\�_O�|.��%s^RMY���!l.e�I����5F�N�I�����[e\R-oeyX(`����ZYU￀#~Xv�9�DE����)ƣ�Q���!�}�C	���^�����4�b�>�I�U�m1I��*�����\������hV���T0�~�J!��S?�8�
�g���M��}�;��
�BͧźV�.h]'��t���|�LI�v�uż��L�v������;kO��A��N�ҷ(�(����M�⭨߶�, F  h}�~6�O�������'1�Vn6�T?+x���U���Ţ5�D�u����F4�i]O]�u֋0�Ti��,"�Oug����S��b�7��ԍ���cU[I?vF����o��=jkIvfm/�u��*��Y�ǋCК����<^�����<^��{&�Ouq���<u[ޓk��kO�ޭɲ�ꞘGs��54ޱ��[lZ����pwA��ק����(���ګ��^��{��/�pN��[�p��l�"��S]�2���|�K����zY����a1^������R}�B3xĂ�Wa��/O�	� 2{�g<��O�e��M3���ī�����W0;���'���}����VVx��!@�9�
�XJ���Wp�Dxn��:��g�[�*�``ntn��j�\(�2�`���� ����yu #���L�NrJ�3(��$.�ۀR��'1yw rP2O���	�I,޷e�]n8�Z�2�:7$^5@/+<F�`a�EC��̵[nx�j�\��f�:�1���,��G0�i��:xĐ5[C.R���c��c�fk��j�dnZ�e�cM1k�-=Fр7�V�6	��|���6����ͬM�s2�d�95�����x69���G{�faxnr�Z����I�� ��f�5,@�91M͎�*1Ć��L�2�o� �7N���C0�ŭ_؂�q$¦�Ea��p^��sYV(.ESJ��nRѰU �5���g��aS���n�aS�� ȭ�ij��:��N�̓f���M/m�̒� su������fR��            x������ � �         /   x�3�tI-H,*I�M�Sp�2B�:q#s��L��.\��\W�=... �@         �   x�}�=�0���>'@u�튘Y�v1?He����j����y�/a N��̧��v�g�rU�uq����[d�vU��F��Bb��8qH�S�:IH�_�Ɖ(4�&.�.)ZZٿ�wpU/V��=�"^l����in9      
   4   x�3��4����/-��OL)�/H�N-�JL��7��Oέ���(������� ,�7         /   x�3��M�KLO-�2�.ILK�2�tL����,.)J,�/����� ��         �   x�U�=n�0Fg�\:�G�Q� YX�]ٲK�{�Z�x	||�T
��u\3.!Ǳ>j�n��8��Ԅ��˃G�p�8��fwxo�&e/�]�A�}�N$��wr��<���s�Rx~1g���#��&q�r����=7�3������O`�u����A�^r���
�G9�^9��<]����+w�B��I�         H  x��RKR�0]'��Z&	��t�`7MƑ�=�m!�PfX���8O��{�n���
�m�H0b���:	Ze���1PSիe�^V�kX�
�ɀE���ڑ�����hrk��[�cOA�:�x4R0h�����!/%�p
I�1��1�Y"�&���]�R��m��6��@Mh�⡇\~�'��B�Gm��4�����x3�J|���˻mGٍ&/��� %l���t�H����8�%���[Ms��֟�ˎ
p8���#6�K�R��o�X��]��I>,R*����^��L��)wտ^����T���zt'            x������ � �            x������ � �            x�3�H-*��K��2��-������ R     