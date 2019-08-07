--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- Name: plpgsql; Type: PROCEDURAL LANGUAGE; Schema: -; Owner: postgres
--

CREATE PROCEDURAL LANGUAGE plpgsql;


ALTER PROCEDURAL LANGUAGE plpgsql OWNER TO postgres;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: user_images; Type: TABLE; Schema: public; Owner: root; Tablespace: 
--

CREATE TABLE user_images (
    email_id character varying(100),
    image_path character varying(350),
    prediction character varying(100),
    date_upload timestamp without time zone
);


ALTER TABLE public.user_images OWNER TO root;

--
-- Name: users; Type: TABLE; Schema: public; Owner: root; Tablespace: 
--

CREATE TABLE users (
    email_id character varying(100) NOT NULL,
    name character varying(100),
    passwd character varying(100),
    pr_image_path character varying(350)
);


ALTER TABLE public.users OWNER TO root;

--
-- Data for Name: user_images; Type: TABLE DATA; Schema: public; Owner: root
--

COPY user_images (email_id, image_path, prediction, date_upload) FROM stdin;
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: root
--

COPY users (email_id, name, passwd, pr_image_path) FROM stdin;
\.


--
-- Name: users_pkey; Type: CONSTRAINT; Schema: public; Owner: root; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (email_id);


--
-- Name: user_images_email_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY user_images
    ADD CONSTRAINT user_images_email_id_fkey FOREIGN KEY (email_id) REFERENCES users(email_id) ON DELETE CASCADE;


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
