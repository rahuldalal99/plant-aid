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
    dname character varying(100) NOT NULL,
    cure character varying(100),
    cause character varying(100)
);


ALTER TABLE public.disease OWNER TO postgres;

--
-- Name: plant; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.plant (
    pname character varying(100) NOT NULL,
    crop_price integer,
    popularity integer
);


ALTER TABLE public.plant OWNER TO postgres;

--
-- Name: plant_disease; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.plant_disease (
    pname character varying(100),
    dname character varying(100),
    cure character varying(100),
    cause character varying(100)
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
    ADD CONSTRAINT disease_pkey PRIMARY KEY (dname);


--
-- Name: plant plant_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.plant
    ADD CONSTRAINT plant_pkey PRIMARY KEY (pname);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (email_id);


--
-- Name: plant_disease p_d_name_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.plant_disease
    ADD CONSTRAINT p_d_name_fkey FOREIGN KEY (pname) REFERENCES public.plant(pname) ON DELETE CASCADE;


--
-- Name: plant_disease p_d_name_fkey1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.plant_disease
    ADD CONSTRAINT p_d_name_fkey1 FOREIGN KEY (dname) REFERENCES public.disease(dname) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

