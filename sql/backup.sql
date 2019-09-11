--
-- PostgreSQL database dump
--

-- Dumped from database version 10.10 (Ubuntu 10.10-0ubuntu0.18.04.1)
-- Dumped by pg_dump version 10.10 (Ubuntu 10.10-0ubuntu0.18.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: DATABASE postgres; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON DATABASE postgres IS 'default administrative connection database';


--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: disease; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.disease (
    disease_id integer NOT NULL,
    disease_name character varying(50),
    disease_symptoms text,
    disease_causes text
);


ALTER TABLE public.disease OWNER TO postgres;

--
-- Name: plant; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.plant (
    plant_id integer NOT NULL,
    plant_name character varying(50),
    plant_sc_name character varying(50),
    wiki character varying(100)
);


ALTER TABLE public.plant OWNER TO postgres;

--
-- Name: plant_disease; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.plant_disease (
    plant_id integer,
    disease_id integer,
    cure text
);


ALTER TABLE public.plant_disease OWNER TO postgres;

--
-- Name: user_images; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.user_images (
    email_id character varying(100),
    image_path character varying(350),
    prediction character varying(100),
    date_upload character varying(30),
    time_upload character varying(30)
);


ALTER TABLE public.user_images OWNER TO postgres;

--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    email_id character varying(100) NOT NULL,
    name character varying(100),
    passwd character varying(100),
    pr_image_path character varying(350)
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: disease disease_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.disease
    ADD CONSTRAINT disease_pkey PRIMARY KEY (disease_id);


--
-- Name: plant plant_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.plant
    ADD CONSTRAINT plant_pkey PRIMARY KEY (plant_id);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (email_id);


--
-- Name: plant_disease plant_disease_disease_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.plant_disease
    ADD CONSTRAINT plant_disease_disease_id_fkey FOREIGN KEY (disease_id) REFERENCES public.disease(disease_id) ON UPDATE SET NULL ON DELETE CASCADE;


--
-- Name: plant_disease plant_disease_plant_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.plant_disease
    ADD CONSTRAINT plant_disease_plant_id_fkey FOREIGN KEY (plant_id) REFERENCES public.plant(plant_id) ON UPDATE SET NULL ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

