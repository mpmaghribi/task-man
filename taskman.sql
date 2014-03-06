PGDMP                         r         
   task_manDB    9.3.3    9.3.3 !    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                       false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                       false            �           1262    16415 
   task_manDB    DATABASE     �   CREATE DATABASE "task_manDB" WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'English_United States.1252' LC_CTYPE = 'English_United States.1252';
    DROP DATABASE "task_manDB";
             postgres    false                        2615    2200    public    SCHEMA        CREATE SCHEMA public;
    DROP SCHEMA public;
             postgres    false            �           0    0    SCHEMA public    COMMENT     6   COMMENT ON SCHEMA public IS 'standard public schema';
                  postgres    false    5            �           0    0    public    ACL     �   REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;
                  postgres    false    5            �            3079    11750    plpgsql 	   EXTENSION     ?   CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;
    DROP EXTENSION plpgsql;
                  false            �           0    0    EXTENSION plpgsql    COMMENT     @   COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';
                       false    177            �            1259    16444    tabel_jabatan    TABLE     j   CREATE TABLE tabel_jabatan (
    id_jabatan integer NOT NULL,
    nama_jabatan character varying(1000)
);
 !   DROP TABLE public.tabel_jabatan;
       public         postgres    false    5            �            1259    16492    id_jabatan_seq    SEQUENCE     p   CREATE SEQUENCE id_jabatan_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.id_jabatan_seq;
       public       postgres    false    171    5            �           0    0    id_jabatan_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE id_jabatan_seq OWNED BY tabel_jabatan.id_jabatan;
            public       postgres    false    176            �            1259    16469    tabel_notifikasi    TABLE     q   CREATE TABLE tabel_notifikasi (
    id_notifikasi integer NOT NULL,
    isi_notifikasi character varying(100)
);
 $   DROP TABLE public.tabel_notifikasi;
       public         postgres    false    5            �            1259    16467    id_notifikasi_seq    SEQUENCE     s   CREATE SEQUENCE id_notifikasi_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.id_notifikasi_seq;
       public       postgres    false    173    5            �           0    0    id_notifikasi_seq    SEQUENCE OWNED BY     J   ALTER SEQUENCE id_notifikasi_seq OWNED BY tabel_notifikasi.id_notifikasi;
            public       postgres    false    172            �            1259    16480    tabel_pekerjaan    TABLE     p   CREATE TABLE tabel_pekerjaan (
    id_pekerjaan integer NOT NULL,
    nama_pekerjaan character varying(1000)
);
 #   DROP TABLE public.tabel_pekerjaan;
       public         postgres    false    5            �            1259    16488    id_pekerjaan_seq    SEQUENCE     r   CREATE SEQUENCE id_pekerjaan_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.id_pekerjaan_seq;
       public       postgres    false    174    5            �           0    0    id_pekerjaan_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE id_pekerjaan_seq OWNED BY tabel_pekerjaan.id_pekerjaan;
            public       postgres    false    175            �            1259    16436 
   tabel_user    TABLE     �   CREATE TABLE tabel_user (
    username character varying(100),
    password character varying(50),
    id_jabatan integer,
    user_id character varying(100) NOT NULL
);
    DROP TABLE public.tabel_user;
       public         postgres    false    5            3           2604    16494 
   id_jabatan    DEFAULT     h   ALTER TABLE ONLY tabel_jabatan ALTER COLUMN id_jabatan SET DEFAULT nextval('id_jabatan_seq'::regclass);
 G   ALTER TABLE public.tabel_jabatan ALTER COLUMN id_jabatan DROP DEFAULT;
       public       postgres    false    176    171            4           2604    16472    id_notifikasi    DEFAULT     q   ALTER TABLE ONLY tabel_notifikasi ALTER COLUMN id_notifikasi SET DEFAULT nextval('id_notifikasi_seq'::regclass);
 M   ALTER TABLE public.tabel_notifikasi ALTER COLUMN id_notifikasi DROP DEFAULT;
       public       postgres    false    173    172    173            5           2604    16490    id_pekerjaan    DEFAULT     n   ALTER TABLE ONLY tabel_pekerjaan ALTER COLUMN id_pekerjaan SET DEFAULT nextval('id_pekerjaan_seq'::regclass);
 K   ALTER TABLE public.tabel_pekerjaan ALTER COLUMN id_pekerjaan DROP DEFAULT;
       public       postgres    false    175    174            �           0    0    id_jabatan_seq    SEQUENCE SET     6   SELECT pg_catalog.setval('id_jabatan_seq', 1, false);
            public       postgres    false    176            �           0    0    id_notifikasi_seq    SEQUENCE SET     8   SELECT pg_catalog.setval('id_notifikasi_seq', 5, true);
            public       postgres    false    172            �           0    0    id_pekerjaan_seq    SEQUENCE SET     8   SELECT pg_catalog.setval('id_pekerjaan_seq', 1, false);
            public       postgres    false    175            �          0    16444    tabel_jabatan 
   TABLE DATA               :   COPY tabel_jabatan (id_jabatan, nama_jabatan) FROM stdin;
    public       postgres    false    171   �        �          0    16469    tabel_notifikasi 
   TABLE DATA               B   COPY tabel_notifikasi (id_notifikasi, isi_notifikasi) FROM stdin;
    public       postgres    false    173   �        �          0    16480    tabel_pekerjaan 
   TABLE DATA               @   COPY tabel_pekerjaan (id_pekerjaan, nama_pekerjaan) FROM stdin;
    public       postgres    false    174   !       �          0    16436 
   tabel_user 
   TABLE DATA               F   COPY tabel_user (username, password, id_jabatan, user_id) FROM stdin;
    public       postgres    false    170   .!       9           2606    16451 
   pk_jabatan 
   CONSTRAINT     W   ALTER TABLE ONLY tabel_jabatan
    ADD CONSTRAINT pk_jabatan PRIMARY KEY (id_jabatan);
 B   ALTER TABLE ONLY public.tabel_jabatan DROP CONSTRAINT pk_jabatan;
       public         postgres    false    171    171            ;           2606    16477    pk_notifikasi 
   CONSTRAINT     `   ALTER TABLE ONLY tabel_notifikasi
    ADD CONSTRAINT pk_notifikasi PRIMARY KEY (id_notifikasi);
 H   ALTER TABLE ONLY public.tabel_notifikasi DROP CONSTRAINT pk_notifikasi;
       public         postgres    false    173    173            =           2606    16487    pk_pekerjaan 
   CONSTRAINT     ]   ALTER TABLE ONLY tabel_pekerjaan
    ADD CONSTRAINT pk_pekerjaan PRIMARY KEY (id_pekerjaan);
 F   ALTER TABLE ONLY public.tabel_pekerjaan DROP CONSTRAINT pk_pekerjaan;
       public         postgres    false    174    174            7           2606    16479    pk_user 
   CONSTRAINT     N   ALTER TABLE ONLY tabel_user
    ADD CONSTRAINT pk_user PRIMARY KEY (user_id);
 <   ALTER TABLE ONLY public.tabel_user DROP CONSTRAINT pk_user;
       public         postgres    false    170    170            >           2606    16454 
   fk_jabatan    FK CONSTRAINT     y   ALTER TABLE ONLY tabel_user
    ADD CONSTRAINT fk_jabatan FOREIGN KEY (id_jabatan) REFERENCES tabel_jabatan(id_jabatan);
 ?   ALTER TABLE ONLY public.tabel_user DROP CONSTRAINT fk_jabatan;
       public       postgres    false    171    170    1849            �      x������ � �      �      x�3��H,J,PH�LJLNT�L����� V*k      �      x������ � �      �      x������ � �     