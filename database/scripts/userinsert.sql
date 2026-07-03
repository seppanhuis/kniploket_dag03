-- Step: 21
-- *****************************************************************
-- Doel : Vul de tabel users met gegevens (17 records)
-- *****************************************************************

INSERT INTO `users`
(
         id
        ,name
        ,email
        ,email_verified_at
        ,password
        ,role
        ,remember_token
        ,created_at
        ,updated_at
        ,IsActief
        ,Opmerking
        ,DatumAangemaakt
        ,DatumGewijzigd
)
VALUES
 (1,'Salon Eigenaar','eigenaar@kniplokettiko.nl',NULL,'$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu','eigenaar',NULL,'2026-07-02 09:09:30','2026-07-02 09:09:30',1,NULL,SYSDATE(6),SYSDATE(6))
,(2,'Fatima El Amrani','fatima@kniplokettiko.nl',NULL,'$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu','medewerker',NULL,'2026-07-02 09:09:30','2026-07-02 09:09:30',1,NULL,SYSDATE(6),SYSDATE(6))
,(3,'Sanne de Vries','sanne.devries@kniplokettiko.nl',NULL,'$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu','medewerker',NULL,'2026-07-02 09:09:30','2026-07-02 09:09:30',1,NULL,SYSDATE(6),SYSDATE(6))
,(4,'Mohamed El Idrissi','mohamed.elidrissi@kniplokettiko.nl',NULL,'$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu','medewerker',NULL,'2026-07-02 09:09:30','2026-07-02 09:09:30',1,NULL,SYSDATE(6),SYSDATE(6))
,(5,'Lisa van Dijk','lisa.vandijk@kniplokettiko.nl',NULL,'$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu','medewerker',NULL,'2026-07-02 09:09:30','2026-07-02 09:09:30',1,NULL,SYSDATE(6),SYSDATE(6))
,(6,'Youssef Benali','youssef.benali@kniplokettiko.nl',NULL,'$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu','medewerker',NULL,'2026-07-02 09:09:30','2026-07-02 09:09:30',1,NULL,SYSDATE(6),SYSDATE(6))
,(7,'Noor Bakker','noor.bakker@kniplokettiko.nl',NULL,'$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu','medewerker',NULL,'2026-07-02 09:09:30','2026-07-02 09:09:30',1,NULL,SYSDATE(6),SYSDATE(6))
,(8,'Kevin Smit','kevin.smit@kniplokettiko.nl',NULL,'$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu','medewerker',NULL,'2026-07-02 09:09:30','2026-07-02 09:09:30',1,NULL,SYSDATE(6),SYSDATE(6))
,(9,'Aylin Demir','aylin.demir@kniplokettiko.nl',NULL,'$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu','medewerker',NULL,'2026-07-02 09:09:30','2026-07-02 09:09:30',1,NULL,SYSDATE(6),SYSDATE(6))
,(10,'Tom Verhoeven','tom.verhoeven@kniplokettiko.nl',NULL,'$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu','medewerker',NULL,'2026-07-02 09:09:30','2026-07-02 09:09:30',1,NULL,SYSDATE(6),SYSDATE(6))
,(11,'Romy Jacobs','romy.jacobs@kniplokettiko.nl',NULL,'$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu','medewerker',NULL,'2026-07-02 09:09:30','2026-07-02 09:09:30',1,NULL,SYSDATE(6),SYSDATE(6))
,(12,'Piet van Loenen','piet.van.loenen@gmail.com',NULL,'$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu','klant',NULL,'2026-07-02 09:09:30','2026-07-02 09:09:30',1,NULL,SYSDATE(6),SYSDATE(6))
,(13,'Jan Jansen','jan.jansen@outlook.com',NULL,'$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu','klant',NULL,'2026-07-02 09:09:30','2026-07-02 09:09:30',1,NULL,SYSDATE(6),SYSDATE(6))
,(14,'Saskia de Boer','saskia.deboer@yahoo.com',NULL,'$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu','klant',NULL,'2026-07-02 09:09:30','2026-07-02 09:09:30',1,NULL,SYSDATE(6),SYSDATE(6))
,(15,'Ahmed Mansouri','ahmed.mansouri@icloud.com',NULL,'$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu','klant',NULL,'2026-07-02 09:09:30','2026-07-02 09:09:30',1,NULL,SYSDATE(6),SYSDATE(6))
,(16,'Marieke van den Berg','marieke.vandenberg@ziggo.nl',NULL,'$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu','klant',NULL,'2026-07-02 09:09:30','2026-07-02 09:09:30',1,NULL,SYSDATE(6),SYSDATE(6))
,(17,'Daan Visser','daan.visser@live.nl',NULL,'$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu','klant',NULL,'2026-07-02 09:09:30','2026-07-02 09:09:30',1,NULL,SYSDATE(6),SYSDATE(6));
