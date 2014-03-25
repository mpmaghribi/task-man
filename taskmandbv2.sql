PGDMP                         r            taskman    9.3.3    9.3.3 H    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                       false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                       false            �           1262    24608    taskman    DATABASE     �   CREATE DATABASE taskman WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'English_United Kingdom.1252' LC_CTYPE = 'English_United Kingdom.1252';
    DROP DATABASE taskman;
             postgres    false                        2615    2200    public    SCHEMA        CREATE SCHEMA public;
    DROP SCHEMA public;
             postgres    false            �           0    0    SCHEMA public    COMMENT     6   COMMENT ON SCHEMA public IS 'standard public schema';
                  postgres    false    5            �            3079    11750    plpgsql 	   EXTENSION     ?   CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;
    DROP EXTENSION plpgsql;
                  false            �           0    0    EXTENSION plpgsql    COMMENT     @   COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';
                       false    182            �            1255    24972 4   function_login(character varying, character varying)    FUNCTION     �  CREATE FUNCTION function_login(f_username character varying, f_pwd character varying) RETURNS record
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
       public       postgres    false    182    5            �            1255    24977 �   function_register(integer, integer, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying)    FUNCTION     )  CREATE FUNCTION function_register(f_jabatan integer, f_departemen integer, f_nip character varying, f_nama character varying, f_alamat character varying, f_gender character varying, f_agama character varying, f_homephone character varying, f_mobilephone character varying, f_email character varying, f_password character varying) RETURNS record
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
       public       postgres    false    182    5            �            1255    24953    tes(integer)    FUNCTION     s   CREATE FUNCTION tes(angka integer) RETURNS integer
    LANGUAGE plpgsql
    AS $$begin
	return angka +100;
end;$$;
 )   DROP FUNCTION public.tes(angka integer);
       public       postgres    false    182    5            �            1259    24820    activity    TABLE     �   CREATE TABLE activity (
    id_activity integer NOT NULL,
    id_akun integer,
    id_detil_pekerjaan integer,
    nama_activity character varying(50),
    deskripsi_activity text,
    tanggal_activity date
);
    DROP TABLE public.activity;
       public         postgres    false    5            �            1259    24959    tbl_akun_id    SEQUENCE     w   CREATE SEQUENCE tbl_akun_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;
 "   DROP SEQUENCE public.tbl_akun_id;
       public       postgres    false    5            �            1259    24831    akun    TABLE     �  CREATE TABLE akun (
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
    akun_password character varying(25)
);
    DROP TABLE public.akun;
       public         postgres    false    179    5            �            1259    24968    tbl_departemen_id    SEQUENCE     s   CREATE SEQUENCE tbl_departemen_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.tbl_departemen_id;
       public       postgres    false    5            �            1259    24839 
   departemen    TABLE     �   CREATE TABLE departemen (
    id_departemen integer DEFAULT nextval('tbl_departemen_id'::regclass) NOT NULL,
    nama_departemen character varying(50)
);
    DROP TABLE public.departemen;
       public         postgres    false    181    5            �            1259    24845    detil_pekerjaan    TABLE       CREATE TABLE detil_pekerjaan (
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
       public         postgres    false    5            �            1259    24853    file    TABLE     t   CREATE TABLE file (
    id_file integer NOT NULL,
    id_pekerjaan integer,
    nama_file character varying(100)
);
    DROP TABLE public.file;
       public         postgres    false    5            �            1259    24965    tbl_jabatan_id    SEQUENCE     p   CREATE SEQUENCE tbl_jabatan_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.tbl_jabatan_id;
       public       postgres    false    5            �            1259    24860    jabatan    TABLE     �   CREATE TABLE jabatan (
    id_jabatan integer DEFAULT nextval('tbl_jabatan_id'::regclass) NOT NULL,
    nama_jabatan character varying(50)
);
    DROP TABLE public.jabatan;
       public         postgres    false    180    5            �            1259    24866    komentar    TABLE     �   CREATE TABLE komentar (
    id_komentar integer NOT NULL,
    id_akun integer,
    id_pekerjaan integer,
    isi_komentar text
);
    DROP TABLE public.komentar;
       public         postgres    false    5            �            1259    24877 	   pekerjaan    TABLE     a  CREATE TABLE pekerjaan (
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
       public         postgres    false    5            �            1259    24887    sifat_pekerjaan    TABLE     z   CREATE TABLE sifat_pekerjaan (
    id_sifat_pekerjaan integer NOT NULL,
    nama_sifat_pekerjaan character varying(50)
);
 #   DROP TABLE public.sifat_pekerjaan;
       public         postgres    false    5            �          0    24820    activity 
   TABLE DATA                     public       postgres    false    170   �T       �          0    24831    akun 
   TABLE DATA                     public       postgres    false    171   	U       �          0    24839 
   departemen 
   TABLE DATA                     public       postgres    false    172   V       �          0    24845    detil_pekerjaan 
   TABLE DATA                     public       postgres    false    173   �V       �          0    24853    file 
   TABLE DATA                     public       postgres    false    174   �V       �          0    24860    jabatan 
   TABLE DATA                     public       postgres    false    175   �V       �          0    24866    komentar 
   TABLE DATA                     public       postgres    false    176   (W       �          0    24877 	   pekerjaan 
   TABLE DATA                     public       postgres    false    177   BW       �          0    24887    sifat_pekerjaan 
   TABLE DATA                     public       postgres    false    178   \W       �           0    0    tbl_akun_id    SEQUENCE SET     2   SELECT pg_catalog.setval('tbl_akun_id', 2, true);
            public       postgres    false    179            �           0    0    tbl_departemen_id    SEQUENCE SET     8   SELECT pg_catalog.setval('tbl_departemen_id', 5, true);
            public       postgres    false    181            �           0    0    tbl_jabatan_id    SEQUENCE SET     5   SELECT pg_catalog.setval('tbl_jabatan_id', 3, true);
            public       postgres    false    180            N           2606    24827    pk_activity 
   CONSTRAINT     T   ALTER TABLE ONLY activity
    ADD CONSTRAINT pk_activity PRIMARY KEY (id_activity);
 >   ALTER TABLE ONLY public.activity DROP CONSTRAINT pk_activity;
       public         postgres    false    170    170            S           2606    24835    pk_akun 
   CONSTRAINT     H   ALTER TABLE ONLY akun
    ADD CONSTRAINT pk_akun PRIMARY KEY (id_akun);
 6   ALTER TABLE ONLY public.akun DROP CONSTRAINT pk_akun;
       public         postgres    false    171    171            X           2606    24843    pk_departemen 
   CONSTRAINT     Z   ALTER TABLE ONLY departemen
    ADD CONSTRAINT pk_departemen PRIMARY KEY (id_departemen);
 B   ALTER TABLE ONLY public.departemen DROP CONSTRAINT pk_departemen;
       public         postgres    false    172    172            [           2606    24849    pk_detil_pekerjaan 
   CONSTRAINT     i   ALTER TABLE ONLY detil_pekerjaan
    ADD CONSTRAINT pk_detil_pekerjaan PRIMARY KEY (id_detil_pekerjaan);
 L   ALTER TABLE ONLY public.detil_pekerjaan DROP CONSTRAINT pk_detil_pekerjaan;
       public         postgres    false    173    173            `           2606    24857    pk_file 
   CONSTRAINT     H   ALTER TABLE ONLY file
    ADD CONSTRAINT pk_file PRIMARY KEY (id_file);
 6   ALTER TABLE ONLY public.file DROP CONSTRAINT pk_file;
       public         postgres    false    174    174            d           2606    24864 
   pk_jabatan 
   CONSTRAINT     Q   ALTER TABLE ONLY jabatan
    ADD CONSTRAINT pk_jabatan PRIMARY KEY (id_jabatan);
 <   ALTER TABLE ONLY public.jabatan DROP CONSTRAINT pk_jabatan;
       public         postgres    false    175    175            g           2606    24873    pk_komentar 
   CONSTRAINT     T   ALTER TABLE ONLY komentar
    ADD CONSTRAINT pk_komentar PRIMARY KEY (id_komentar);
 >   ALTER TABLE ONLY public.komentar DROP CONSTRAINT pk_komentar;
       public         postgres    false    176    176            l           2606    24884    pk_pekerjaan 
   CONSTRAINT     W   ALTER TABLE ONLY pekerjaan
    ADD CONSTRAINT pk_pekerjaan PRIMARY KEY (id_pekerjaan);
 @   ALTER TABLE ONLY public.pekerjaan DROP CONSTRAINT pk_pekerjaan;
       public         postgres    false    177    177            o           2606    24891    pk_sifat_pekerjaan 
   CONSTRAINT     i   ALTER TABLE ONLY sifat_pekerjaan
    ADD CONSTRAINT pk_sifat_pekerjaan PRIMARY KEY (id_sifat_pekerjaan);
 L   ALTER TABLE ONLY public.sifat_pekerjaan DROP CONSTRAINT pk_sifat_pekerjaan;
       public         postgres    false    178    178            L           1259    24828    activity_pk    INDEX     G   CREATE UNIQUE INDEX activity_pk ON activity USING btree (id_activity);
    DROP INDEX public.activity_pk;
       public         postgres    false    170            Q           1259    24836    akun_pk    INDEX     ;   CREATE UNIQUE INDEX akun_pk ON akun USING btree (id_akun);
    DROP INDEX public.akun_pk;
       public         postgres    false    171            V           1259    24844    departemen_pk    INDEX     M   CREATE UNIQUE INDEX departemen_pk ON departemen USING btree (id_departemen);
 !   DROP INDEX public.departemen_pk;
       public         postgres    false    172            Y           1259    24850    detil_pekerjaan_pk    INDEX     \   CREATE UNIQUE INDEX detil_pekerjaan_pk ON detil_pekerjaan USING btree (id_detil_pekerjaan);
 &   DROP INDEX public.detil_pekerjaan_pk;
       public         postgres    false    173            ^           1259    24858    file_pk    INDEX     ;   CREATE UNIQUE INDEX file_pk ON file USING btree (id_file);
    DROP INDEX public.file_pk;
       public         postgres    false    174            b           1259    24865 
   jabatan_pk    INDEX     D   CREATE UNIQUE INDEX jabatan_pk ON jabatan USING btree (id_jabatan);
    DROP INDEX public.jabatan_pk;
       public         postgres    false    175            e           1259    24874    komentar_pk    INDEX     G   CREATE UNIQUE INDEX komentar_pk ON komentar USING btree (id_komentar);
    DROP INDEX public.komentar_pk;
       public         postgres    false    176            j           1259    24885    pekerjaan_pk    INDEX     J   CREATE UNIQUE INDEX pekerjaan_pk ON pekerjaan USING btree (id_pekerjaan);
     DROP INDEX public.pekerjaan_pk;
       public         postgres    false    177            O           1259    24830    relationship_10_fk    INDEX     N   CREATE INDEX relationship_10_fk ON activity USING btree (id_detil_pekerjaan);
 &   DROP INDEX public.relationship_10_fk;
       public         postgres    false    170            T           1259    24837    relationship_1_fk    INDEX     A   CREATE INDEX relationship_1_fk ON akun USING btree (id_jabatan);
 %   DROP INDEX public.relationship_1_fk;
       public         postgres    false    171            U           1259    24838    relationship_2_fk    INDEX     D   CREATE INDEX relationship_2_fk ON akun USING btree (id_departemen);
 %   DROP INDEX public.relationship_2_fk;
       public         postgres    false    171            \           1259    24851    relationship_3_fk    INDEX     I   CREATE INDEX relationship_3_fk ON detil_pekerjaan USING btree (id_akun);
 %   DROP INDEX public.relationship_3_fk;
       public         postgres    false    173            ]           1259    24852    relationship_4_fk    INDEX     N   CREATE INDEX relationship_4_fk ON detil_pekerjaan USING btree (id_pekerjaan);
 %   DROP INDEX public.relationship_4_fk;
       public         postgres    false    173            m           1259    24886    relationship_5_fk    INDEX     N   CREATE INDEX relationship_5_fk ON pekerjaan USING btree (id_sifat_pekerjaan);
 %   DROP INDEX public.relationship_5_fk;
       public         postgres    false    177            h           1259    24875    relationship_6_fk    INDEX     B   CREATE INDEX relationship_6_fk ON komentar USING btree (id_akun);
 %   DROP INDEX public.relationship_6_fk;
       public         postgres    false    176            i           1259    24876    relationship_7_fk    INDEX     G   CREATE INDEX relationship_7_fk ON komentar USING btree (id_pekerjaan);
 %   DROP INDEX public.relationship_7_fk;
       public         postgres    false    176            a           1259    24859    relationship_8_fk    INDEX     C   CREATE INDEX relationship_8_fk ON file USING btree (id_pekerjaan);
 %   DROP INDEX public.relationship_8_fk;
       public         postgres    false    174            P           1259    24829    relationship_9_fk    INDEX     B   CREATE INDEX relationship_9_fk ON activity USING btree (id_akun);
 %   DROP INDEX public.relationship_9_fk;
       public         postgres    false    170            p           1259    24892    sifat_pekerjaan_pk    INDEX     \   CREATE UNIQUE INDEX sifat_pekerjaan_pk ON sifat_pekerjaan USING btree (id_sifat_pekerjaan);
 &   DROP INDEX public.sifat_pekerjaan_pk;
       public         postgres    false    178            r           2606    24898    fk_activity_relations_akun    FK CONSTRAINT     �   ALTER TABLE ONLY activity
    ADD CONSTRAINT fk_activity_relations_akun FOREIGN KEY (id_akun) REFERENCES akun(id_akun) ON UPDATE RESTRICT ON DELETE RESTRICT;
 M   ALTER TABLE ONLY public.activity DROP CONSTRAINT fk_activity_relations_akun;
       public       postgres    false    170    1875    171            q           2606    24893    fk_activity_relations_detil_pe    FK CONSTRAINT     �   ALTER TABLE ONLY activity
    ADD CONSTRAINT fk_activity_relations_detil_pe FOREIGN KEY (id_detil_pekerjaan) REFERENCES detil_pekerjaan(id_detil_pekerjaan) ON UPDATE RESTRICT ON DELETE RESTRICT;
 Q   ALTER TABLE ONLY public.activity DROP CONSTRAINT fk_activity_relations_detil_pe;
       public       postgres    false    170    1883    173            t           2606    24908    fk_akun_relations_departem    FK CONSTRAINT     �   ALTER TABLE ONLY akun
    ADD CONSTRAINT fk_akun_relations_departem FOREIGN KEY (id_departemen) REFERENCES departemen(id_departemen) ON UPDATE RESTRICT ON DELETE RESTRICT;
 I   ALTER TABLE ONLY public.akun DROP CONSTRAINT fk_akun_relations_departem;
       public       postgres    false    1880    172    171            s           2606    24903    fk_akun_relations_jabatan    FK CONSTRAINT     �   ALTER TABLE ONLY akun
    ADD CONSTRAINT fk_akun_relations_jabatan FOREIGN KEY (id_jabatan) REFERENCES jabatan(id_jabatan) ON UPDATE RESTRICT ON DELETE RESTRICT;
 H   ALTER TABLE ONLY public.akun DROP CONSTRAINT fk_akun_relations_jabatan;
       public       postgres    false    175    171    1892            u           2606    24913    fk_detil_pe_relations_akun    FK CONSTRAINT     �   ALTER TABLE ONLY detil_pekerjaan
    ADD CONSTRAINT fk_detil_pe_relations_akun FOREIGN KEY (id_akun) REFERENCES akun(id_akun) ON UPDATE RESTRICT ON DELETE RESTRICT;
 T   ALTER TABLE ONLY public.detil_pekerjaan DROP CONSTRAINT fk_detil_pe_relations_akun;
       public       postgres    false    173    171    1875            v           2606    24918    fk_detil_pe_relations_pekerjaa    FK CONSTRAINT     �   ALTER TABLE ONLY detil_pekerjaan
    ADD CONSTRAINT fk_detil_pe_relations_pekerjaa FOREIGN KEY (id_pekerjaan) REFERENCES pekerjaan(id_pekerjaan) ON UPDATE RESTRICT ON DELETE RESTRICT;
 X   ALTER TABLE ONLY public.detil_pekerjaan DROP CONSTRAINT fk_detil_pe_relations_pekerjaa;
       public       postgres    false    173    177    1900            w           2606    24923    fk_file_relations_pekerjaa    FK CONSTRAINT     �   ALTER TABLE ONLY file
    ADD CONSTRAINT fk_file_relations_pekerjaa FOREIGN KEY (id_pekerjaan) REFERENCES pekerjaan(id_pekerjaan) ON UPDATE RESTRICT ON DELETE RESTRICT;
 I   ALTER TABLE ONLY public.file DROP CONSTRAINT fk_file_relations_pekerjaa;
       public       postgres    false    1900    177    174            x           2606    24928    fk_komentar_relations_akun    FK CONSTRAINT     �   ALTER TABLE ONLY komentar
    ADD CONSTRAINT fk_komentar_relations_akun FOREIGN KEY (id_akun) REFERENCES akun(id_akun) ON UPDATE RESTRICT ON DELETE RESTRICT;
 M   ALTER TABLE ONLY public.komentar DROP CONSTRAINT fk_komentar_relations_akun;
       public       postgres    false    1875    171    176            y           2606    24933    fk_komentar_relations_pekerjaa    FK CONSTRAINT     �   ALTER TABLE ONLY komentar
    ADD CONSTRAINT fk_komentar_relations_pekerjaa FOREIGN KEY (id_pekerjaan) REFERENCES pekerjaan(id_pekerjaan) ON UPDATE RESTRICT ON DELETE RESTRICT;
 Q   ALTER TABLE ONLY public.komentar DROP CONSTRAINT fk_komentar_relations_pekerjaa;
       public       postgres    false    176    1900    177            z           2606    24938    fk_pekerjaa_relations_sifat_pe    FK CONSTRAINT     �   ALTER TABLE ONLY pekerjaan
    ADD CONSTRAINT fk_pekerjaa_relations_sifat_pe FOREIGN KEY (id_sifat_pekerjaan) REFERENCES sifat_pekerjaan(id_sifat_pekerjaan) ON UPDATE RESTRICT ON DELETE RESTRICT;
 R   ALTER TABLE ONLY public.pekerjaan DROP CONSTRAINT fk_pekerjaa_relations_sifat_pe;
       public       postgres    false    177    1903    178            �   
   x���          �   �   x�͑=o�0���������֥"�A"�5:jL�8��P�}�N?`afy�=�Ow�]��z����m �� 3-�h8�9�N^�]PFQ:�r��B�pV��m�(�t��T�FK���A��4����uro�~��lɡ�Wկ2�����c�i��d��P�R&��%�cRE��hO�)ĤE�_�H��8h�iӽ\��"���|w|�'4%l����hb��8<L�?a��/���Y���      �   c   x���v
Q���WHI-H,*I�M�S��L�Gpu�s�4�}B]�4u�]��5��<)4��L'j�i�j�35�4A5Ӆf����
2�� �[��      �   
   x���          �   
   x���          �   d   x���v
Q���W�JLJ,I�S��L���u�sa<M�0G�P�`Cu�ļ���"uMk.O�L1�\���F��@3Sr3�2�K�K����� �Cp      �   
   x���          �   
   x���          �   
   x���         