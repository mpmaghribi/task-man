PGDMP     .    2                r            taskman    9.3.3    9.3.3 I    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                       false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                       false            �           1262    16415    taskman    DATABASE     �   CREATE DATABASE taskman WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'English_United States.1252' LC_CTYPE = 'English_United States.1252';
    DROP DATABASE taskman;
             postgres    false                        2615    2200    public    SCHEMA        CREATE SCHEMA public;
    DROP SCHEMA public;
             postgres    false            �           0    0    SCHEMA public    COMMENT     6   COMMENT ON SCHEMA public IS 'standard public schema';
                  postgres    false    6            �           0    0    public    ACL     �   REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;
                  postgres    false    6            �            3079    11750    plpgsql 	   EXTENSION     ?   CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;
    DROP EXTENSION plpgsql;
                  false            �           0    0    EXTENSION plpgsql    COMMENT     @   COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';
                       false    182            �            1255    16689 4   function_login(character varying, character varying)    FUNCTION     �  CREATE FUNCTION function_login(f_username character varying, f_pwd character varying) RETURNS record
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
       public       postgres    false    6    182            �            1255    16690 �   function_register(integer, integer, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying)    FUNCTION     )  CREATE FUNCTION function_register(f_jabatan integer, f_departemen integer, f_nip character varying, f_nama character varying, f_alamat character varying, f_gender character varying, f_agama character varying, f_homephone character varying, f_mobilephone character varying, f_email character varying, f_password character varying) RETURNS record
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
       public       postgres    false    182    6            �            1255    16691    tes(integer)    FUNCTION     s   CREATE FUNCTION tes(angka integer) RETURNS integer
    LANGUAGE plpgsql
    AS $$begin
	return angka +100;
end;$$;
 )   DROP FUNCTION public.tes(angka integer);
       public       postgres    false    6    182            �            1259    16692    activity    TABLE     �   CREATE TABLE activity (
    id_activity integer NOT NULL,
    id_akun integer,
    id_detil_pekerjaan integer,
    nama_activity character varying(50),
    deskripsi_activity text,
    tanggal_activity date
);
    DROP TABLE public.activity;
       public         postgres    false    6            �            1259    16698    tbl_akun_id    SEQUENCE     w   CREATE SEQUENCE tbl_akun_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;
 "   DROP SEQUENCE public.tbl_akun_id;
       public       postgres    false    6            �            1259    16700    akun    TABLE     �  CREATE TABLE akun (
    id_akun integer DEFAULT nextval('tbl_akun_id'::regclass) NOT NULL,
    id_jabatan integer,
    id_departemen integer,
    nip character varying(50),
    nama character varying(50),
    alamat character varying(100),
    jenis_kelamin character varying(2),
    agama character varying(15),
    telepon character varying(25),
    hp character varying(25),
    email character varying(25),
    akun_password character varying(32)
);
    DROP TABLE public.akun;
       public         postgres    false    171    6            �            1259    16704    tbl_departemen_id    SEQUENCE     s   CREATE SEQUENCE tbl_departemen_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.tbl_departemen_id;
       public       postgres    false    6            �            1259    16706 
   departemen    TABLE     �   CREATE TABLE departemen (
    id_departemen integer DEFAULT nextval('tbl_departemen_id'::regclass) NOT NULL,
    nama_departemen character varying(50)
);
    DROP TABLE public.departemen;
       public         postgres    false    173    6            �            1259    16710    detil_pekerjaan    TABLE       CREATE TABLE detil_pekerjaan (
    id_detil_pekerjaan integer NOT NULL,
    id_pekerjaan integer,
    id_akun integer,
    consignee integer,
    pemberi_pekerjaan integer,
    tgl_read date,
    tglasli_mulai date,
    tglaslli_selesai date,
    skor integer,
    progress integer
);
 #   DROP TABLE public.detil_pekerjaan;
       public         postgres    false    6            �            1259    16713    file    TABLE     t   CREATE TABLE file (
    id_file integer NOT NULL,
    id_pekerjaan integer,
    nama_file character varying(100)
);
    DROP TABLE public.file;
       public         postgres    false    6            �            1259    16716    tbl_jabatan_id    SEQUENCE     p   CREATE SEQUENCE tbl_jabatan_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.tbl_jabatan_id;
       public       postgres    false    6            �            1259    16718    jabatan    TABLE     �   CREATE TABLE jabatan (
    id_jabatan integer DEFAULT nextval('tbl_jabatan_id'::regclass) NOT NULL,
    nama_jabatan character varying(50)
);
    DROP TABLE public.jabatan;
       public         postgres    false    177    6            �            1259    16722    komentar    TABLE     �   CREATE TABLE komentar (
    id_komentar integer NOT NULL,
    id_akun integer,
    id_pekerjaan integer,
    isi_komentar text
);
    DROP TABLE public.komentar;
       public         postgres    false    6            �            1259    16728 	   pekerjaan    TABLE     a  CREATE TABLE pekerjaan (
    id_pekerjaan integer NOT NULL,
    id_sifat_pekerjaan integer,
    parent_pekerjaan integer,
    nama_pekerjaan character varying(50),
    deskripsi_pekerjaan text,
    tgl_mulai date,
    tgl_selesai date,
    status_pekerjaan character varying(25),
    asal_pekerjaan character varying(50),
    level_prioritas integer
);
    DROP TABLE public.pekerjaan;
       public         postgres    false    6            �            1259    16734    sifat_pekerjaan    TABLE     z   CREATE TABLE sifat_pekerjaan (
    id_sifat_pekerjaan integer NOT NULL,
    nama_sifat_pekerjaan character varying(50)
);
 #   DROP TABLE public.sifat_pekerjaan;
       public         postgres    false    6            �          0    16692    activity 
   TABLE DATA               z   COPY activity (id_activity, id_akun, id_detil_pekerjaan, nama_activity, deskripsi_activity, tanggal_activity) FROM stdin;
    public       postgres    false    170   �Y       �          0    16700    akun 
   TABLE DATA               �   COPY akun (id_akun, id_jabatan, id_departemen, nip, nama, alamat, jenis_kelamin, agama, telepon, hp, email, akun_password) FROM stdin;
    public       postgres    false    172   �Y       �          0    16706 
   departemen 
   TABLE DATA               =   COPY departemen (id_departemen, nama_departemen) FROM stdin;
    public       postgres    false    174   �Z       �          0    16710    detil_pekerjaan 
   TABLE DATA               �   COPY detil_pekerjaan (id_detil_pekerjaan, id_pekerjaan, id_akun, consignee, pemberi_pekerjaan, tgl_read, tglasli_mulai, tglaslli_selesai, skor, progress) FROM stdin;
    public       postgres    false    175   �Z       �          0    16713    file 
   TABLE DATA               9   COPY file (id_file, id_pekerjaan, nama_file) FROM stdin;
    public       postgres    false    176   �Z       �          0    16718    jabatan 
   TABLE DATA               4   COPY jabatan (id_jabatan, nama_jabatan) FROM stdin;
    public       postgres    false    178   �Z       �          0    16722    komentar 
   TABLE DATA               M   COPY komentar (id_komentar, id_akun, id_pekerjaan, isi_komentar) FROM stdin;
    public       postgres    false    179   :[       �          0    16728 	   pekerjaan 
   TABLE DATA               �   COPY pekerjaan (id_pekerjaan, id_sifat_pekerjaan, parent_pekerjaan, nama_pekerjaan, deskripsi_pekerjaan, tgl_mulai, tgl_selesai, status_pekerjaan, asal_pekerjaan, level_prioritas) FROM stdin;
    public       postgres    false    180   W[       �          0    16734    sifat_pekerjaan 
   TABLE DATA               L   COPY sifat_pekerjaan (id_sifat_pekerjaan, nama_sifat_pekerjaan) FROM stdin;
    public       postgres    false    181   t[       �           0    0    tbl_akun_id    SEQUENCE SET     2   SELECT pg_catalog.setval('tbl_akun_id', 2, true);
            public       postgres    false    171            �           0    0    tbl_departemen_id    SEQUENCE SET     8   SELECT pg_catalog.setval('tbl_departemen_id', 5, true);
            public       postgres    false    173            �           0    0    tbl_jabatan_id    SEQUENCE SET     5   SELECT pg_catalog.setval('tbl_jabatan_id', 3, true);
            public       postgres    false    177            N           2606    16738    pk_activity 
   CONSTRAINT     T   ALTER TABLE ONLY activity
    ADD CONSTRAINT pk_activity PRIMARY KEY (id_activity);
 >   ALTER TABLE ONLY public.activity DROP CONSTRAINT pk_activity;
       public         postgres    false    170    170            S           2606    16740    pk_akun 
   CONSTRAINT     H   ALTER TABLE ONLY akun
    ADD CONSTRAINT pk_akun PRIMARY KEY (id_akun);
 6   ALTER TABLE ONLY public.akun DROP CONSTRAINT pk_akun;
       public         postgres    false    172    172            X           2606    16742    pk_departemen 
   CONSTRAINT     Z   ALTER TABLE ONLY departemen
    ADD CONSTRAINT pk_departemen PRIMARY KEY (id_departemen);
 B   ALTER TABLE ONLY public.departemen DROP CONSTRAINT pk_departemen;
       public         postgres    false    174    174            [           2606    16744    pk_detil_pekerjaan 
   CONSTRAINT     i   ALTER TABLE ONLY detil_pekerjaan
    ADD CONSTRAINT pk_detil_pekerjaan PRIMARY KEY (id_detil_pekerjaan);
 L   ALTER TABLE ONLY public.detil_pekerjaan DROP CONSTRAINT pk_detil_pekerjaan;
       public         postgres    false    175    175            `           2606    16746    pk_file 
   CONSTRAINT     H   ALTER TABLE ONLY file
    ADD CONSTRAINT pk_file PRIMARY KEY (id_file);
 6   ALTER TABLE ONLY public.file DROP CONSTRAINT pk_file;
       public         postgres    false    176    176            d           2606    16748 
   pk_jabatan 
   CONSTRAINT     Q   ALTER TABLE ONLY jabatan
    ADD CONSTRAINT pk_jabatan PRIMARY KEY (id_jabatan);
 <   ALTER TABLE ONLY public.jabatan DROP CONSTRAINT pk_jabatan;
       public         postgres    false    178    178            g           2606    16750    pk_komentar 
   CONSTRAINT     T   ALTER TABLE ONLY komentar
    ADD CONSTRAINT pk_komentar PRIMARY KEY (id_komentar);
 >   ALTER TABLE ONLY public.komentar DROP CONSTRAINT pk_komentar;
       public         postgres    false    179    179            l           2606    16752    pk_pekerjaan 
   CONSTRAINT     W   ALTER TABLE ONLY pekerjaan
    ADD CONSTRAINT pk_pekerjaan PRIMARY KEY (id_pekerjaan);
 @   ALTER TABLE ONLY public.pekerjaan DROP CONSTRAINT pk_pekerjaan;
       public         postgres    false    180    180            o           2606    16754    pk_sifat_pekerjaan 
   CONSTRAINT     i   ALTER TABLE ONLY sifat_pekerjaan
    ADD CONSTRAINT pk_sifat_pekerjaan PRIMARY KEY (id_sifat_pekerjaan);
 L   ALTER TABLE ONLY public.sifat_pekerjaan DROP CONSTRAINT pk_sifat_pekerjaan;
       public         postgres    false    181    181            L           1259    16755    activity_pk    INDEX     G   CREATE UNIQUE INDEX activity_pk ON activity USING btree (id_activity);
    DROP INDEX public.activity_pk;
       public         postgres    false    170            Q           1259    16756    akun_pk    INDEX     ;   CREATE UNIQUE INDEX akun_pk ON akun USING btree (id_akun);
    DROP INDEX public.akun_pk;
       public         postgres    false    172            V           1259    16757    departemen_pk    INDEX     M   CREATE UNIQUE INDEX departemen_pk ON departemen USING btree (id_departemen);
 !   DROP INDEX public.departemen_pk;
       public         postgres    false    174            Y           1259    16758    detil_pekerjaan_pk    INDEX     \   CREATE UNIQUE INDEX detil_pekerjaan_pk ON detil_pekerjaan USING btree (id_detil_pekerjaan);
 &   DROP INDEX public.detil_pekerjaan_pk;
       public         postgres    false    175            ^           1259    16759    file_pk    INDEX     ;   CREATE UNIQUE INDEX file_pk ON file USING btree (id_file);
    DROP INDEX public.file_pk;
       public         postgres    false    176            b           1259    16760 
   jabatan_pk    INDEX     D   CREATE UNIQUE INDEX jabatan_pk ON jabatan USING btree (id_jabatan);
    DROP INDEX public.jabatan_pk;
       public         postgres    false    178            e           1259    16761    komentar_pk    INDEX     G   CREATE UNIQUE INDEX komentar_pk ON komentar USING btree (id_komentar);
    DROP INDEX public.komentar_pk;
       public         postgres    false    179            j           1259    16762    pekerjaan_pk    INDEX     J   CREATE UNIQUE INDEX pekerjaan_pk ON pekerjaan USING btree (id_pekerjaan);
     DROP INDEX public.pekerjaan_pk;
       public         postgres    false    180            O           1259    16763    relationship_10_fk    INDEX     N   CREATE INDEX relationship_10_fk ON activity USING btree (id_detil_pekerjaan);
 &   DROP INDEX public.relationship_10_fk;
       public         postgres    false    170            T           1259    16764    relationship_1_fk    INDEX     A   CREATE INDEX relationship_1_fk ON akun USING btree (id_jabatan);
 %   DROP INDEX public.relationship_1_fk;
       public         postgres    false    172            U           1259    16765    relationship_2_fk    INDEX     D   CREATE INDEX relationship_2_fk ON akun USING btree (id_departemen);
 %   DROP INDEX public.relationship_2_fk;
       public         postgres    false    172            \           1259    16766    relationship_3_fk    INDEX     I   CREATE INDEX relationship_3_fk ON detil_pekerjaan USING btree (id_akun);
 %   DROP INDEX public.relationship_3_fk;
       public         postgres    false    175            ]           1259    16767    relationship_4_fk    INDEX     N   CREATE INDEX relationship_4_fk ON detil_pekerjaan USING btree (id_pekerjaan);
 %   DROP INDEX public.relationship_4_fk;
       public         postgres    false    175            m           1259    16768    relationship_5_fk    INDEX     N   CREATE INDEX relationship_5_fk ON pekerjaan USING btree (id_sifat_pekerjaan);
 %   DROP INDEX public.relationship_5_fk;
       public         postgres    false    180            h           1259    16769    relationship_6_fk    INDEX     B   CREATE INDEX relationship_6_fk ON komentar USING btree (id_akun);
 %   DROP INDEX public.relationship_6_fk;
       public         postgres    false    179            i           1259    16770    relationship_7_fk    INDEX     G   CREATE INDEX relationship_7_fk ON komentar USING btree (id_pekerjaan);
 %   DROP INDEX public.relationship_7_fk;
       public         postgres    false    179            a           1259    16771    relationship_8_fk    INDEX     C   CREATE INDEX relationship_8_fk ON file USING btree (id_pekerjaan);
 %   DROP INDEX public.relationship_8_fk;
       public         postgres    false    176            P           1259    16772    relationship_9_fk    INDEX     B   CREATE INDEX relationship_9_fk ON activity USING btree (id_akun);
 %   DROP INDEX public.relationship_9_fk;
       public         postgres    false    170            p           1259    16773    sifat_pekerjaan_pk    INDEX     \   CREATE UNIQUE INDEX sifat_pekerjaan_pk ON sifat_pekerjaan USING btree (id_sifat_pekerjaan);
 &   DROP INDEX public.sifat_pekerjaan_pk;
       public         postgres    false    181            q           2606    16774    fk_activity_relations_akun    FK CONSTRAINT     �   ALTER TABLE ONLY activity
    ADD CONSTRAINT fk_activity_relations_akun FOREIGN KEY (id_akun) REFERENCES akun(id_akun) ON UPDATE RESTRICT ON DELETE RESTRICT;
 M   ALTER TABLE ONLY public.activity DROP CONSTRAINT fk_activity_relations_akun;
       public       postgres    false    170    172    1875            r           2606    16779    fk_activity_relations_detil_pe    FK CONSTRAINT     �   ALTER TABLE ONLY activity
    ADD CONSTRAINT fk_activity_relations_detil_pe FOREIGN KEY (id_detil_pekerjaan) REFERENCES detil_pekerjaan(id_detil_pekerjaan) ON UPDATE RESTRICT ON DELETE RESTRICT;
 Q   ALTER TABLE ONLY public.activity DROP CONSTRAINT fk_activity_relations_detil_pe;
       public       postgres    false    170    175    1883            s           2606    16784    fk_akun_relations_departem    FK CONSTRAINT     �   ALTER TABLE ONLY akun
    ADD CONSTRAINT fk_akun_relations_departem FOREIGN KEY (id_departemen) REFERENCES departemen(id_departemen) ON UPDATE RESTRICT ON DELETE RESTRICT;
 I   ALTER TABLE ONLY public.akun DROP CONSTRAINT fk_akun_relations_departem;
       public       postgres    false    172    174    1880            t           2606    16789    fk_akun_relations_jabatan    FK CONSTRAINT     �   ALTER TABLE ONLY akun
    ADD CONSTRAINT fk_akun_relations_jabatan FOREIGN KEY (id_jabatan) REFERENCES jabatan(id_jabatan) ON UPDATE RESTRICT ON DELETE RESTRICT;
 H   ALTER TABLE ONLY public.akun DROP CONSTRAINT fk_akun_relations_jabatan;
       public       postgres    false    172    178    1892            u           2606    16794    fk_detil_pe_relations_akun    FK CONSTRAINT     �   ALTER TABLE ONLY detil_pekerjaan
    ADD CONSTRAINT fk_detil_pe_relations_akun FOREIGN KEY (id_akun) REFERENCES akun(id_akun) ON UPDATE RESTRICT ON DELETE RESTRICT;
 T   ALTER TABLE ONLY public.detil_pekerjaan DROP CONSTRAINT fk_detil_pe_relations_akun;
       public       postgres    false    175    172    1875            v           2606    16799    fk_detil_pe_relations_pekerjaa    FK CONSTRAINT     �   ALTER TABLE ONLY detil_pekerjaan
    ADD CONSTRAINT fk_detil_pe_relations_pekerjaa FOREIGN KEY (id_pekerjaan) REFERENCES pekerjaan(id_pekerjaan) ON UPDATE RESTRICT ON DELETE RESTRICT;
 X   ALTER TABLE ONLY public.detil_pekerjaan DROP CONSTRAINT fk_detil_pe_relations_pekerjaa;
       public       postgres    false    175    180    1900            w           2606    16804    fk_file_relations_pekerjaa    FK CONSTRAINT     �   ALTER TABLE ONLY file
    ADD CONSTRAINT fk_file_relations_pekerjaa FOREIGN KEY (id_pekerjaan) REFERENCES pekerjaan(id_pekerjaan) ON UPDATE RESTRICT ON DELETE RESTRICT;
 I   ALTER TABLE ONLY public.file DROP CONSTRAINT fk_file_relations_pekerjaa;
       public       postgres    false    176    180    1900            x           2606    16809    fk_komentar_relations_akun    FK CONSTRAINT     �   ALTER TABLE ONLY komentar
    ADD CONSTRAINT fk_komentar_relations_akun FOREIGN KEY (id_akun) REFERENCES akun(id_akun) ON UPDATE RESTRICT ON DELETE RESTRICT;
 M   ALTER TABLE ONLY public.komentar DROP CONSTRAINT fk_komentar_relations_akun;
       public       postgres    false    1875    172    179            y           2606    16814    fk_komentar_relations_pekerjaa    FK CONSTRAINT     �   ALTER TABLE ONLY komentar
    ADD CONSTRAINT fk_komentar_relations_pekerjaa FOREIGN KEY (id_pekerjaan) REFERENCES pekerjaan(id_pekerjaan) ON UPDATE RESTRICT ON DELETE RESTRICT;
 Q   ALTER TABLE ONLY public.komentar DROP CONSTRAINT fk_komentar_relations_pekerjaa;
       public       postgres    false    179    1900    180            z           2606    16819    fk_pekerjaa_relations_sifat_pe    FK CONSTRAINT     �   ALTER TABLE ONLY pekerjaan
    ADD CONSTRAINT fk_pekerjaa_relations_sifat_pe FOREIGN KEY (id_sifat_pekerjaan) REFERENCES sifat_pekerjaan(id_sifat_pekerjaan) ON UPDATE RESTRICT ON DELETE RESTRICT;
 R   ALTER TABLE ONLY public.pekerjaan DROP CONSTRAINT fk_pekerjaa_relations_sifat_pe;
       public       postgres    false    180    181    1903            �      x������ � �      �   �   x���M
�0F��)<A�̴i�� ��n�I2�
mE���-.>f���ހ�s���ǵ�Tޑ��V���q%R�d�%
J`�@컫M���8�6'�q|Zq���M{'���$R��~�����%��f�K��j�>�����|��S�7\���r�@�R�0��3)��O�      �   /   x�3�tI-H,*I�M�Sp�2B�:q#s��L��.\��\W�=... �@      �      x������ � �      �      x������ � �      �   /   x�3��M�KLO-�2�.ILK�2�tL����,.)J,�/����� ��      �      x������ � �      �      x������ � �      �      x������ � �     