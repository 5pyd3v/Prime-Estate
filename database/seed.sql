-- Generic Real Estate CMS — Demo Seed Data
-- Realistic demo content for a Pakistani real-estate agency ("Prime Estates").
-- All values below are fully editable from the admin panel after import.

USE `realestate_cms`;

SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- users  (login: admin@primeestates.pk / Admin@12345)
-- ---------------------------------------------------------------------
INSERT INTO `users` (`id`,`name`,`email`,`password_hash`,`role`,`status`) VALUES
(1,'Admin User','admin@primeestates.pk','$2y$10$rVqV4bABVVFSrgk1ITq58uJx9s7PA0EBXSSnxHwC5xawC1XaiB50y','super_admin','active');

-- ---------------------------------------------------------------------
-- media  (demo assets — hotlinked placeholder services, replace via Media Library)
-- ---------------------------------------------------------------------
INSERT INTO `media` (`id`,`filename`,`original_name`,`path`,`mime_type`,`file_type`,`size`,`alt_text`,`uploaded_by`) VALUES
(1,'logo.png','logo.png','https://placehold.co/240x64/00271A/FFFFFF?text=Prime+Estates','image/png','image',0,'Prime Estates logo',1),
(2,'favicon.png','favicon.png','https://placehold.co/64x64/00271A/FFFFFF?text=PE','image/png','image',0,'Prime Estates favicon',1),
(3,'hero-1.jpg','hero-1.jpg','https://picsum.photos/seed/prime-hero-1/1920/1080','image/jpeg','image',0,'Modern home exterior',1),
(4,'hero-2.jpg','hero-2.jpg','https://picsum.photos/seed/prime-hero-2/1920/1080','image/jpeg','image',0,'Bright living room',1),
(5,'hero-3.jpg','hero-3.jpg','https://picsum.photos/seed/prime-hero-3/1920/1080','image/jpeg','image',0,'City skyline at dusk',1),
(6,'prop-1-a.jpg','prop-1-a.jpg','https://picsum.photos/seed/prime-prop-1a/1200/800','image/jpeg','image',0,'House exterior',1),
(7,'prop-1-b.jpg','prop-1-b.jpg','https://picsum.photos/seed/prime-prop-1b/1200/800','image/jpeg','image',0,'Living room',1),
(8,'prop-2-a.jpg','prop-2-a.jpg','https://picsum.photos/seed/prime-prop-2a/1200/800','image/jpeg','image',0,'Apartment building',1),
(9,'prop-2-b.jpg','prop-2-b.jpg','https://picsum.photos/seed/prime-prop-2b/1200/800','image/jpeg','image',0,'Apartment interior',1),
(10,'prop-3-a.jpg','prop-3-a.jpg','https://picsum.photos/seed/prime-prop-3a/1200/800','image/jpeg','image',0,'Furnished apartment',1),
(11,'prop-3-b.jpg','prop-3-b.jpg','https://picsum.photos/seed/prime-prop-3b/1200/800','image/jpeg','image',0,'Bedroom',1),
(12,'prop-4-a.jpg','prop-4-a.jpg','https://picsum.photos/seed/prime-prop-4a/1200/800','image/jpeg','image',0,'Residential plot',1),
(13,'prop-5-a.jpg','prop-5-a.jpg','https://picsum.photos/seed/prime-prop-5a/1200/800','image/jpeg','image',0,'Villa exterior',1),
(14,'prop-5-b.jpg','prop-5-b.jpg','https://picsum.photos/seed/prime-prop-5b/1200/800','image/jpeg','image',0,'Villa pool',1),
(15,'prop-6-a.jpg','prop-6-a.jpg','https://picsum.photos/seed/prime-prop-6a/1200/800','image/jpeg','image',0,'House front',1),
(16,'prop-7-a.jpg','prop-7-a.jpg','https://picsum.photos/seed/prime-prop-7a/1200/800','image/jpeg','image',0,'Commercial plaza',1),
(17,'prop-8-a.jpg','prop-8-a.jpg','https://picsum.photos/seed/prime-prop-8a/1200/800','image/jpeg','image',0,'1 Kanal house',1),
(18,'prop-8-b.jpg','prop-8-b.jpg','https://picsum.photos/seed/prime-prop-8b/1200/800','image/jpeg','image',0,'Dining area',1),
(19,'prop-9-a.jpg','prop-9-a.jpg','https://picsum.photos/seed/prime-prop-9a/1200/800','image/jpeg','image',0,'Apartment block',1),
(20,'prop-10-a.jpg','prop-10-a.jpg','https://picsum.photos/seed/prime-prop-10a/1200/800','image/jpeg','image',0,'Farmhouse',1),
(21,'prop-10-b.jpg','prop-10-b.jpg','https://picsum.photos/seed/prime-prop-10b/1200/800','image/jpeg','image',0,'Farmhouse lawn',1),
(22,'prop-11-a.jpg','prop-11-a.jpg','https://picsum.photos/seed/prime-prop-11a/1200/800','image/jpeg','image',0,'Modern house DHA',1),
(23,'prop-11-b.jpg','prop-11-b.jpg','https://picsum.photos/seed/prime-prop-11b/1200/800','image/jpeg','image',0,'House interior',1),
(24,'prop-12-a.jpg','prop-12-a.jpg','https://picsum.photos/seed/prime-prop-12a/1200/800','image/jpeg','image',0,'Gulberg apartment',1),
(25,'prop-13-a.jpg','prop-13-a.jpg','https://picsum.photos/seed/prime-prop-13a/1200/800','image/jpeg','image',0,'Retail shop front',1),
(26,'prop-14-a.jpg','prop-14-a.jpg','https://picsum.photos/seed/prime-prop-14a/1200/800','image/jpeg','image',0,'Plot in Bahria Town',1),
(27,'prop-15-a.jpg','prop-15-a.jpg','https://picsum.photos/seed/prime-prop-15a/1200/800','image/jpeg','image',0,'Office space',1),
(28,'prop-16-a.jpg','prop-16-a.jpg','https://picsum.photos/seed/prime-prop-16a/1200/800','image/jpeg','image',0,'Sea view apartment',1),
(29,'prop-16-b.jpg','prop-16-b.jpg','https://picsum.photos/seed/prime-prop-16b/1200/800','image/jpeg','image',0,'Balcony sea view',1),
(30,'prop-17-a.jpg','prop-17-a.jpg','https://picsum.photos/seed/prime-prop-17a/1200/800','image/jpeg','image',0,'DHA bungalow',1),
(31,'prop-18-a.jpg','prop-18-a.jpg','https://picsum.photos/seed/prime-prop-18a/1200/800','image/jpeg','image',0,'Warehouse',1),
(41,'agent-1.jpg','agent-1.jpg','https://i.pravatar.cc/400?img=12','image/jpeg','image',0,'Ahmed Raza',1),
(42,'agent-2.jpg','agent-2.jpg','https://i.pravatar.cc/400?img=32','image/jpeg','image',0,'Ayesha Khan',1),
(43,'agent-3.jpg','agent-3.jpg','https://i.pravatar.cc/400?img=13','image/jpeg','image',0,'Bilal Sheikh',1),
(44,'agent-4.jpg','agent-4.jpg','https://i.pravatar.cc/400?img=45','image/jpeg','image',0,'Sana Malik',1),
(45,'agent-5.jpg','agent-5.jpg','https://i.pravatar.cc/400?img=14','image/jpeg','image',0,'Usman Tariq',1),
(50,'project-1-a.jpg','project-1-a.jpg','https://picsum.photos/seed/prime-proj-1a/1200/800','image/jpeg','image',0,'Emirates Enclave',1),
(51,'project-1-b.jpg','project-1-b.jpg','https://picsum.photos/seed/prime-proj-1b/1200/800','image/jpeg','image',0,'Emirates Enclave amenities',1),
(52,'project-1-logo.png','project-1-logo.png','https://placehold.co/160x160/00271A/FFFFFF?text=EE','image/png','image',0,'Emirates Enclave logo',1),
(53,'project-2-a.jpg','project-2-a.jpg','https://picsum.photos/seed/prime-proj-2a/1200/800','image/jpeg','image',0,'Skyline Residency',1),
(54,'project-2-b.jpg','project-2-b.jpg','https://picsum.photos/seed/prime-proj-2b/1200/800','image/jpeg','image',0,'Skyline Residency towers',1),
(55,'project-2-logo.png','project-2-logo.png','https://placehold.co/160x160/00271A/FFFFFF?text=SR','image/png','image',0,'Skyline Residency logo',1),
(56,'project-3-a.jpg','project-3-a.jpg','https://picsum.photos/seed/prime-proj-3a/1200/800','image/jpeg','image',0,'Ocean Heights',1),
(57,'project-3-b.jpg','project-3-b.jpg','https://picsum.photos/seed/prime-proj-3b/1200/800','image/jpeg','image',0,'Ocean Heights lobby',1),
(58,'project-3-logo.png','project-3-logo.png','https://placehold.co/160x160/00271A/FFFFFF?text=OH','image/png','image',0,'Ocean Heights logo',1),
(61,'testimonial-1.jpg','testimonial-1.jpg','https://i.pravatar.cc/200?img=21','image/jpeg','image',0,'Fahad Nadeem',1),
(62,'testimonial-2.jpg','testimonial-2.jpg','https://i.pravatar.cc/200?img=25','image/jpeg','image',0,'Mahnoor Aslam',1),
(63,'testimonial-3.jpg','testimonial-3.jpg','https://i.pravatar.cc/200?img=33','image/jpeg','image',0,'Zeeshan Iqbal','1'),
(64,'testimonial-4.jpg','testimonial-4.jpg','https://i.pravatar.cc/200?img=47','image/jpeg','image',0,'Hina Yousaf',1),
(65,'testimonial-5.jpg','testimonial-5.jpg','https://i.pravatar.cc/200?img=51','image/jpeg','image',0,'Kamran Butt',1),
(66,'testimonial-6.jpg','testimonial-6.jpg','https://i.pravatar.cc/200?img=60','image/jpeg','image',0,'Sadia Rehman',1),
(71,'blog-1.jpg','blog-1.jpg','https://picsum.photos/seed/prime-blog-1/1200/700','image/jpeg','image',0,'Buying a plot',1),
(72,'blog-2.jpg','blog-2.jpg','https://picsum.photos/seed/prime-blog-2/1200/700','image/jpeg','image',0,'Lahore skyline',1),
(73,'blog-3.jpg','blog-3.jpg','https://picsum.photos/seed/prime-blog-3/1200/700','image/jpeg','image',0,'First home keys',1),
(74,'blog-4.jpg','blog-4.jpg','https://picsum.photos/seed/prime-blog-4/1200/700','image/jpeg','image',0,'Karachi investment',1),
(75,'blog-5.jpg','blog-5.jpg','https://picsum.photos/seed/prime-blog-5/1200/700','image/jpeg','image',0,'Renting vs buying',1),
(76,'blog-6.jpg','blog-6.jpg','https://picsum.photos/seed/prime-blog-6/1200/700','image/jpeg','image',0,'Property documents',1),
(81,'about-team.jpg','about-team.jpg','https://picsum.photos/seed/prime-about-team/1400/900','image/jpeg','image',0,'Prime Estates team',1),
(82,'about-office.jpg','about-office.jpg','https://picsum.photos/seed/prime-about-office/1400/900','image/jpeg','image',0,'Prime Estates office',1);

-- ---------------------------------------------------------------------
-- settings
-- ---------------------------------------------------------------------
INSERT INTO `settings` (`setting_key`,`setting_value`,`setting_group`) VALUES
('site_name','Prime Estates','general'),
('company_name','Prime Estates (Pvt.) Ltd.','general'),
('tagline','Find a Place You''ll Love to Call Home','general'),
('logo_media_id','1','branding'),
('favicon_media_id','2','branding'),
('primary_color','#00271A','branding'),
('secondary_color','#8B3A1F','branding'),
('accent_color','#D4A657','branding'),
('bg_color','#FFFBF1','branding'),
('text_color','#272220','branding'),
('button_style','pill','branding'),
('border_radius','18','branding'),
('phone','+92 51 111 222 333','contact'),
('whatsapp','+923001234567','contact'),
('email','info@primeestates.pk','contact'),
('address','Plot 12, Block C, F-7 Markaz, Islamabad, Pakistan','contact'),
('google_maps_url','https://maps.google.com/?q=F-7+Markaz+Islamabad+Pakistan','contact'),
('working_hours','Mon – Sat: 9:00 AM – 7:00 PM','contact'),
('facebook_url','https://facebook.com/','social'),
('instagram_url','https://instagram.com/','social'),
('linkedin_url','https://linkedin.com/','social'),
('youtube_url','https://youtube.com/','social'),
('tiktok_url','','social'),
('default_seo_title','Prime Estates — Find Your Perfect Place in Pakistan','seo'),
('default_seo_description','Browse verified houses, apartments, plots and commercial properties for sale and rent across Islamabad, Rawalpindi, Lahore and Karachi.','seo'),
('hero_heading','Find a Place You''ll Love to Call Home','homepage'),
('hero_subheading','Handpicked homes, apartments and plots across Pakistan''s most desirable neighborhoods.','homepage'),
('hero_cta_text','Browse Properties','homepage'),
('hero_cta_url','/properties','homepage'),
('hero_secondary_cta_text','List Your Property','homepage'),
('hero_secondary_cta_url','/contact','homepage'),
('hero_image_1','3','homepage'),
('hero_image_2','4','homepage'),
('hero_image_3','5','homepage'),
('hero_overlay_opacity','0.45','homepage'),
('footer_description','Prime Estates helps you buy, rent and invest in verified properties across Pakistan with a modern, transparent experience.','footer'),
('footer_copyright','© {year} Prime Estates. All rights reserved.','footer'),
('whatsapp_default_message','Hello, I am interested in your properties.','whatsapp'),
('notify_email','info@primeestates.pk','email'),
('notify_from_name','Prime Estates','email'),
('nav_style','floating-pill','appearance'),
('container_width','1280','appearance');

-- ---------------------------------------------------------------------
-- cities / areas
-- ---------------------------------------------------------------------
INSERT INTO `cities` (`id`,`name`,`slug`,`is_active`,`sort_order`) VALUES
(1,'Islamabad','islamabad',1,1),
(2,'Rawalpindi','rawalpindi',1,2),
(3,'Lahore','lahore',1,3),
(4,'Karachi','karachi',1,4);

INSERT INTO `areas` (`id`,`city_id`,`name`,`slug`,`is_active`,`sort_order`) VALUES
(1,1,'F-10','f-10',1,1),
(2,1,'F-11','f-11',1,2),
(3,1,'DHA Islamabad Phase 2','dha-islamabad-phase-2',1,3),
(4,1,'Bahria Town Islamabad Phase 8','bahria-town-islamabad-phase-8',1,4),
(5,1,'G-13','g-13',1,5),
(6,1,'Blue Area','blue-area',1,6),
(7,2,'Bahria Town Rawalpindi Phase 4','bahria-town-rawalpindi-phase-4',1,1),
(8,2,'Askari 14','askari-14',1,2),
(9,3,'DHA Phase 6','dha-phase-6',1,1),
(10,3,'Gulberg III','gulberg-iii',1,2),
(11,3,'Bahria Town Lahore Sector C','bahria-town-lahore-sector-c',1,3),
(12,4,'DHA Phase 8','dha-phase-8',1,1),
(13,4,'Clifton Block 5','clifton-block-5',1,2),
(14,4,'Karachi Industrial Area','karachi-industrial-area',1,3);

-- ---------------------------------------------------------------------
-- property_types
-- ---------------------------------------------------------------------
INSERT INTO `property_types` (`id`,`name`,`slug`,`icon`,`sort_order`,`is_active`) VALUES
(1,'House','house','home',1,1),
(2,'Apartment','apartment','building',2,1),
(3,'Villa','villa','villa',3,1),
(4,'Commercial','commercial','briefcase',4,1),
(5,'Office','office','office',5,1),
(6,'Plot','plot','map-pin',6,1),
(7,'Farmhouse','farmhouse','tree',7,1),
(8,'Shop','shop','store',8,1),
(9,'Warehouse','warehouse','warehouse',9,1),
(10,'Land','land','land',10,1);

-- ---------------------------------------------------------------------
-- features
-- ---------------------------------------------------------------------
INSERT INTO `features` (`id`,`name`,`slug`,`icon`,`sort_order`,`is_active`) VALUES
(1,'Air Conditioning','air-conditioning','snowflake',1,1),
(2,'Parking','parking','car',2,1),
(3,'Security Staff','security-staff','shield',3,1),
(4,'Electricity Backup','electricity-backup','battery',4,1),
(5,'Gas','gas','flame',5,1),
(6,'Water Supply','water-supply','droplet',6,1),
(7,'Furnished','furnished','sofa',7,1),
(8,'Balcony','balcony','door-open',8,1),
(9,'Garden','garden','leaf',9,1),
(10,'Terrace','terrace','sun',10,1),
(11,'Swimming Pool','swimming-pool','waves',11,1),
(12,'Elevator','elevator','arrow-up-down',12,1),
(13,'Gym','gym','dumbbell',13,1),
(14,'Servant Quarter','servant-quarter','home',14,1),
(15,'CCTV','cctv','camera',15,1);

-- ---------------------------------------------------------------------
-- agents
-- ---------------------------------------------------------------------
INSERT INTO `agents` (`id`,`name`,`slug`,`photo_media_id`,`designation`,`phone`,`whatsapp`,`email`,`bio`,`facebook_url`,`instagram_url`,`linkedin_url`,`is_active`,`sort_order`) VALUES
(1,'Ahmed Raza','ahmed-raza',41,'Senior Property Consultant','+923001112223','+923001112223','ahmed.raza@primeestates.pk','Ahmed has spent over a decade helping families find homes across Islamabad, with deep knowledge of F-Sectors and Bahria Town.','https://facebook.com/','https://instagram.com/','https://linkedin.com/',1,1),
(2,'Ayesha Khan','ayesha-khan',42,'Sales Manager','+923004445556','+923004445556','ayesha.khan@primeestates.pk','Ayesha leads our Lahore sales team, specializing in DHA and Gulberg residential deals.','https://facebook.com/','https://instagram.com/','https://linkedin.com/',1,2),
(3,'Bilal Sheikh','bilal-sheikh',43,'Investment Advisor','+923007778889','+923007778889','bilal.sheikh@primeestates.pk','Bilal advises investors on high-growth areas in Karachi, from Clifton to DHA City.','https://facebook.com/','https://instagram.com/','https://linkedin.com/',1,3),
(4,'Sana Malik','sana-malik',44,'Rental Specialist','+923009990001','+923009990001','sana.malik@primeestates.pk','Sana focuses on rental placements across Rawalpindi and Islamabad, matching tenants with the right home fast.','https://facebook.com/','https://instagram.com/','https://linkedin.com/',1,4),
(5,'Usman Tariq','usman-tariq',45,'Commercial Property Expert','+923002223334','+923002223334','usman.tariq@primeestates.pk','Usman handles commercial plazas, offices and warehouse leasing for businesses expanding across Pakistan.','https://facebook.com/','https://instagram.com/','https://linkedin.com/',1,5);

-- ---------------------------------------------------------------------
-- projects / project_images
-- ---------------------------------------------------------------------
INSERT INTO `projects` (`id`,`name`,`slug`,`developer`,`city_id`,`location`,`description`,`logo_media_id`,`starting_price`,`price_label`,`status`,`completion_date`,`amenities`,`payment_plan`,`video_url`,`map_url`,`is_featured`,`is_published`,`seo_title`,`seo_description`) VALUES
(1,'Emirates Enclave','emirates-enclave','Emirates Developers (Pvt.) Ltd.',1,'Bahria Town Islamabad','A gated residential community offering 5, 7 and 10 Marla plots with parks, mosques and a dedicated commercial zone, designed for modern family living.',52,35000000,'Starting from','ongoing','2027-06-30','["Gated Community","24/7 Security","Parks & Green Belts","Mosque","Community Center","Underground Electrification"]','20% down payment, balance in 16 quarterly installments.','',' https://maps.google.com/?q=Bahria+Town+Islamabad',1,1,'Emirates Enclave — Bahria Town Islamabad | Prime Estates','Residential plots in Emirates Enclave, Bahria Town Islamabad. Flexible payment plans, gated security, and modern amenities.'),
(2,'Skyline Residency','skyline-residency','Skyline Builders & Developers',3,'DHA Phase 6, Lahore','A premium high-rise apartment complex in the heart of DHA Lahore featuring 2 & 3 bedroom units, rooftop amenities and smart-home features.',55,28000000,'Starting from','upcoming','2028-01-31','["Rooftop Infinity Pool","Smart Home Automation","Fitness Center","Covered Parking","24/7 Concierge"]','15% down payment, balance in 20 monthly installments.','',' https://maps.google.com/?q=DHA+Phase+6+Lahore',1,1,'Skyline Residency — DHA Phase 6, Lahore | Prime Estates','Luxury apartments in Skyline Residency, DHA Phase 6 Lahore. Smart-home units with rooftop amenities and flexible plans.'),
(3,'Ocean Heights','ocean-heights','Ocean Group of Companies',4,'Clifton, Karachi','A completed waterfront residential tower in Clifton offering sea-facing apartments and penthouses with resort-style amenities.',58,60000000,'Starting from','completed','2024-03-15','["Sea View","Infinity Pool","Private Beach Access","Clubhouse","Kids Play Area"]','Full payment or bank financing available.','',' https://maps.google.com/?q=Clifton+Karachi',0,1,'Ocean Heights — Clifton, Karachi | Prime Estates','Sea-facing apartments and penthouses in Ocean Heights, Clifton Karachi. Move-in ready with resort-style amenities.');

INSERT INTO `project_images` (`project_id`,`media_id`,`sort_order`,`is_primary`) VALUES
(1,50,1,1),(1,51,2,0),
(2,53,1,1),(2,54,2,0),
(3,56,1,1),(3,57,2,0);

-- ---------------------------------------------------------------------
-- properties
-- ---------------------------------------------------------------------
INSERT INTO `properties`
(`id`,`title`,`slug`,`property_type_id`,`purpose`,`price`,`price_label`,`currency`,`status`,`is_featured`,`is_published`,`city_id`,`area_id`,`address`,`map_url`,`bedrooms`,`bathrooms`,`kitchens`,`parking_spaces`,`floors`,`area_size`,`area_unit`,`covered_area`,`year_built`,`furnished_status`,`short_description`,`description`,`agent_id`,`seo_title`,`seo_description`)
VALUES
(1,'Modern 5-Bedroom House in F-10','modern-5-bedroom-house-in-f-10',1,'sale',180000000,NULL,'PKR','available',1,1,1,1,'Street 12, F-10/2, Islamabad','https://maps.google.com/?q=F-10+Islamabad',5,6,1,3,3,1000,'Sq. Yd',6500,2019,'semi_furnished','A spacious, light-filled 5-bedroom house in one of Islamabad''s most established sectors.','This beautifully maintained house in F-10 offers generous living spaces, a modern kitchen, a landscaped lawn and ample parking. Located minutes from Kohsar Market and top schools, it is ideal for families seeking comfort and convenience in central Islamabad.',1,'Modern 5-Bedroom House for Sale in F-10, Islamabad','5-bed, 6-bath house on a 1000 sq. yd plot in F-10, Islamabad. Semi-furnished, 3 car parking, landscaped lawn.'),
(2,'Luxury 3-Bed Apartment in Bahria Town Islamabad','luxury-3-bed-apartment-bahria-town-islamabad',2,'sale',45000000,NULL,'PKR','available',1,1,1,4,'Civic Center, Bahria Town Phase 8, Islamabad','https://maps.google.com/?q=Bahria+Town+Islamabad',3,3,1,1,1,1800,'Sq. Ft',1800,2021,'unfurnished','Contemporary 3-bedroom apartment with resort-style community amenities.','Located within a secure gated community, this apartment features an open-plan living area, en-suite bedrooms and access to parks, a gym and a shopping mall — all within walking distance.',1,'3-Bed Apartment for Sale in Bahria Town Islamabad','Luxury 3-bedroom, 3-bath apartment in Bahria Town Islamabad Phase 8 with gated community amenities.'),
(3,'Furnished 2-Bed Apartment for Rent in F-11','furnished-2-bed-apartment-rent-f-11',2,'rent',150000,'/month','PKR','available',1,1,1,2,'Park Road, F-11/1, Islamabad','https://maps.google.com/?q=F-11+Islamabad',2,2,1,1,1,1200,'Sq. Ft',1200,2018,'furnished','Fully furnished apartment ready for immediate move-in, close to Centaurus Mall.','A tastefully furnished 2-bedroom apartment with modern appliances, backup electricity and 24/7 security — perfect for professionals and small families.',4,'Furnished 2-Bed Apartment for Rent in F-11, Islamabad','Fully furnished 2-bedroom apartment for rent in F-11, Islamabad at PKR 150,000/month.'),
(4,'10 Marla Residential Plot in DHA Islamabad Phase 2','10-marla-plot-dha-islamabad-phase-2',6,'sale',65000000,NULL,'PKR','available',0,1,1,3,'Sector B, DHA Phase 2, Islamabad','https://maps.google.com/?q=DHA+Phase+2+Islamabad',NULL,NULL,NULL,NULL,NULL,10,'Marla',NULL,NULL,'unfurnished','Prime corner plot ready for construction in a rapidly developing DHA sector.','This 10 Marla plot sits on a wide corner in a well-planned block of DHA Islamabad Phase 2, with possession available and all dues clear.',1,'10 Marla Plot for Sale in DHA Islamabad Phase 2','Corner 10 Marla residential plot for sale in DHA Islamabad Phase 2, possession available.'),
(5,'Contemporary Villa in Bahria Town Islamabad Phase 8','contemporary-villa-bahria-town-islamabad-phase-8',3,'sale',95000000,NULL,'PKR','available',1,1,1,4,'Overseas Enclave, Bahria Town Phase 8, Islamabad','https://maps.google.com/?q=Bahria+Town+Islamabad',4,5,1,4,2,2000,'Sq. Yd',3200,2022,'semi_furnished','A striking modern villa with a private pool, ideal for luxury family living.','This architecturally distinct villa features double-height ceilings, a private swimming pool, a home theatre room and a fully landscaped garden.',1,'Modern Villa for Sale in Bahria Town Islamabad Phase 8','4-bed luxury villa with private pool in Bahria Town Islamabad Phase 8.'),
(6,'3-Bed House for Rent in G-13, Islamabad','3-bed-house-rent-g-13-islamabad',1,'rent',180000,'/month','PKR','available',0,1,1,5,'Street 5, G-13/2, Islamabad','https://maps.google.com/?q=G-13+Islamabad',3,3,1,2,2,500,'Sq. Yd',2200,2020,'unfurnished','Well-maintained double-storey house available for immediate rent.','Close to schools, mosques and a commercial market, this house offers a practical family layout with a small lawn and covered parking.',4,'3-Bed House for Rent in G-13, Islamabad','3-bedroom double-storey house for rent in G-13, Islamabad at PKR 180,000/month.'),
(7,'Commercial Plaza Space in Blue Area, Islamabad','commercial-plaza-space-blue-area-islamabad',4,'sale',220000000,NULL,'PKR','available',0,1,1,6,'Jinnah Avenue, Blue Area, Islamabad','https://maps.google.com/?q=Blue+Area+Islamabad',NULL,4,NULL,10,5,5000,'Sq. Ft',5000,2017,'unfurnished','High-visibility commercial space on Islamabad''s primary business corridor.','Positioned on Jinnah Avenue with excellent foot traffic, this plaza space suits corporate offices, banks or flagship retail outlets.',5,'Commercial Space for Sale in Blue Area, Islamabad','5000 sq. ft. commercial plaza space for sale on Jinnah Avenue, Blue Area Islamabad.'),
(8,'1 Kanal House in Bahria Town Rawalpindi Phase 4','1-kanal-house-bahria-town-rawalpindi-phase-4',1,'sale',85000000,NULL,'PKR','available',1,1,2,7,'Chenab Block, Bahria Town Phase 4, Rawalpindi','https://maps.google.com/?q=Bahria+Town+Rawalpindi',5,6,1,4,2,1,'Kanal',4800,2020,'semi_furnished','A grand 1 Kanal house with premium finishes in a gated community.','Featuring a marble entrance, spacious bedrooms with attached baths, and a rooftop terrace with skyline views.',4,'1 Kanal House for Sale in Bahria Town Rawalpindi Phase 4','5-bed 1 Kanal house for sale in Bahria Town Rawalpindi Phase 4.'),
(9,'Cozy 2-Bed Apartment in Askari 14, Rawalpindi','cozy-2-bed-apartment-askari-14-rawalpindi',2,'rent',65000,'/month','PKR','available',0,1,2,8,'Askari 14, Rawalpindi','https://maps.google.com/?q=Askari+14+Rawalpindi',2,2,1,1,1,900,'Sq. Ft',900,2016,'semi_furnished','Comfortable apartment in a secure military housing society.','Ideal for small families, this apartment offers reliable utilities, backup generators and a peaceful neighborhood.',4,'2-Bed Apartment for Rent in Askari 14, Rawalpindi','Semi-furnished 2-bedroom apartment for rent in Askari 14, Rawalpindi.'),
(10,'Luxury Farmhouse near Rawalpindi','luxury-farmhouse-near-rawalpindi',7,'sale',150000000,NULL,'PKR','available',1,1,2,7,'Chak Beli Khan Road, Rawalpindi','https://maps.google.com/?q=Rawalpindi',6,7,2,10,2,4,'Kanal',6000,2021,'furnished','An expansive weekend retreat with orchards, a pool and staff quarters.','Set on 4 Kanal of landscaped grounds, this farmhouse includes a private pool, guest house, mature fruit orchard and generous entertaining spaces.',3,'Luxury Farmhouse for Sale near Rawalpindi','6-bed luxury farmhouse on 4 Kanal near Rawalpindi with pool and orchard.'),
(11,'1 Kanal Modern House in DHA Phase 6, Lahore','1-kanal-modern-house-dha-phase-6-lahore',1,'sale',120000000,NULL,'PKR','available',1,1,3,9,'Block D, DHA Phase 6, Lahore','https://maps.google.com/?q=DHA+Phase+6+Lahore',5,6,1,4,3,1,'Kanal',5200,2022,'semi_furnished','A architect-designed home combining modern lines with functional family living.','Floor-to-ceiling windows, an open-plan kitchen and a rooftop lounge make this one of DHA Phase 6''s standout listings.',2,'1 Kanal House for Sale in DHA Phase 6, Lahore','5-bed modern 1 Kanal house for sale in DHA Phase 6, Lahore.'),
(12,'Elegant Apartment in Gulberg III, Lahore','elegant-apartment-gulberg-iii-lahore',2,'rent',120000,'/month','PKR','available',1,1,3,10,'MM Alam Road, Gulberg III, Lahore','https://maps.google.com/?q=Gulberg+III+Lahore',3,3,1,1,1,1600,'Sq. Ft',1600,2019,'furnished','Centrally located furnished apartment steps from MM Alam Road dining and retail.','A stylish, fully furnished apartment with quick access to Lahore''s best restaurants, cafes and boutiques.',2,'Furnished Apartment for Rent in Gulberg III, Lahore','3-bed furnished apartment for rent on MM Alam Road, Gulberg III Lahore.'),
(13,'Retail Shop in Gulberg, Lahore','retail-shop-gulberg-lahore',8,'sale',55000000,NULL,'PKR','available',0,1,3,10,'Main Boulevard, Gulberg, Lahore','https://maps.google.com/?q=Gulberg+Lahore',NULL,1,NULL,NULL,1,800,'Sq. Ft',800,2015,'unfurnished','A high-footfall retail shop on Gulberg''s Main Boulevard.','Suitable for a flagship retail brand, cafe or showroom, with excellent street frontage and signage visibility.',2,'Retail Shop for Sale in Gulberg, Lahore','800 sq. ft. retail shop for sale on Main Boulevard, Gulberg Lahore.'),
(14,'10 Marla Plot in Bahria Town Lahore','10-marla-plot-bahria-town-lahore',6,'sale',42000000,NULL,'PKR','available',0,1,3,11,'Sector C, Bahria Town, Lahore','https://maps.google.com/?q=Bahria+Town+Lahore',NULL,NULL,NULL,NULL,NULL,10,'Marla',NULL,NULL,'unfurnished','Ready-to-build residential plot in a well-developed Bahria Town sector.','Located close to parks and community facilities, this plot is fully developed with possession available immediately.',2,'10 Marla Plot for Sale in Bahria Town Lahore','Residential 10 Marla plot for sale in Sector C, Bahria Town Lahore.'),
(15,'Office Space in DHA Phase 6, Lahore','office-space-dha-phase-6-lahore',5,'rent',250000,'/month','PKR','available',0,1,3,9,'Commercial Broadway, DHA Phase 6, Lahore','https://maps.google.com/?q=DHA+Phase+6+Lahore',NULL,2,NULL,6,1,2500,'Sq. Ft',2500,2020,'unfurnished','Grade-A office floor suitable for a growing team.','Open-plan layout with meeting rooms, dedicated parking and 24/7 building security in DHA''s commercial hub.',5,'Office Space for Rent in DHA Phase 6, Lahore','2500 sq. ft. office space for rent on Commercial Broadway, DHA Phase 6 Lahore.'),
(16,'Sea View Apartment in Clifton, Karachi','sea-view-apartment-clifton-karachi',2,'sale',75000000,NULL,'PKR','available',1,1,4,13,'Block 5, Clifton, Karachi','https://maps.google.com/?q=Clifton+Karachi',3,4,1,2,1,2100,'Sq. Ft',2100,2023,'semi_furnished','Uninterrupted sea views from every room in this brand-new tower.','Floor-to-ceiling glazing frames panoramic Arabian Sea views, with resort-style amenities including a pool and gym.',3,'Sea View Apartment for Sale in Clifton, Karachi','3-bed sea-facing apartment for sale in Clifton Block 5, Karachi.'),
(17,'500 Sq. Yd Bungalow in DHA Phase 8, Karachi','500-sqyd-bungalow-dha-phase-8-karachi',1,'sale',140000000,NULL,'PKR','available',0,1,4,12,'Zone A, DHA Phase 8, Karachi','https://maps.google.com/?q=DHA+Phase+8+Karachi',5,6,1,4,2,500,'Sq. Yd',4200,2021,'unfurnished','A generously proportioned bungalow in one of Karachi''s premier zones.','This bungalow offers wide lawns, a servant quarter and a practical layout suited to large families.',3,'500 Sq. Yd Bungalow for Sale in DHA Phase 8, Karachi','5-bed 500 sq. yd bungalow for sale in DHA Phase 8, Karachi.'),
(18,'Warehouse Space in Karachi Industrial Area','warehouse-space-karachi-industrial-area',9,'rent',400000,'/month','PKR','available',0,1,4,14,'Sector 15, Korangi Industrial Area, Karachi','https://maps.google.com/?q=Korangi+Industrial+Area+Karachi',NULL,2,NULL,8,1,10000,'Sq. Ft',10000,2014,'unfurnished','Large-span warehouse with easy container access, ideal for logistics operations.','Featuring high ceilings, loading docks and three-phase power, this facility suits distribution or light manufacturing use.',5,'Warehouse for Rent in Korangi Industrial Area, Karachi','10,000 sq. ft. warehouse for rent in Korangi Industrial Area, Karachi.');

INSERT INTO `property_images` (`property_id`,`media_id`,`sort_order`,`is_primary`) VALUES
(1,6,1,1),(1,7,2,0),
(2,8,1,1),(2,9,2,0),
(3,10,1,1),(3,11,2,0),
(4,12,1,1),
(5,13,1,1),(5,14,2,0),
(6,15,1,1),
(7,16,1,1),
(8,17,1,1),(8,18,2,0),
(9,19,1,1),
(10,20,1,1),(10,21,2,0),
(11,22,1,1),(11,23,2,0),
(12,24,1,1),
(13,25,1,1),
(14,26,1,1),
(15,27,1,1),
(16,28,1,1),(16,29,2,0),
(17,30,1,1),
(18,31,1,1);

INSERT INTO `property_features` (`property_id`,`feature_id`) VALUES
(1,1),(1,2),(1,3),(1,4),(1,9),
(2,1),(2,2),(2,3),(2,12),(2,13),
(3,1),(3,2),(3,4),(3,7),
(4,6),
(5,1),(5,2),(5,3),(5,9),(5,11),
(6,2),(6,4),(6,9),
(7,2),(7,3),(7,4),(7,15),
(8,1),(8,2),(8,3),(8,4),(8,14),
(9,2),(9,4),(9,6),
(10,1),(10,2),(10,3),(10,9),(10,11),(10,14),
(11,1),(11,2),(11,3),(11,9),
(12,1),(12,2),(12,7),(12,12),
(13,3),(13,4),(13,15),
(14,6),
(15,1),(15,2),(15,3),(15,4),(15,12),
(16,1),(16,2),(16,3),(16,8),(16,11),(16,13),
(17,1),(17,2),(17,9),(17,14),
(18,2),(18,3),(18,4),(18,15);

-- ---------------------------------------------------------------------
-- services
-- ---------------------------------------------------------------------
INSERT INTO `services` (`id`,`title`,`slug`,`icon`,`short_description`,`description`,`sort_order`,`is_published`) VALUES
(1,'Property Sales','property-sales','home','End-to-end support for buying and selling residential and commercial property.','Our sales team guides you through every stage of a transaction — from valuation and marketing to negotiation and transfer — ensuring a smooth, transparent process.',1,1),
(2,'Property Rentals','property-rentals','key','Fast, reliable tenant and landlord matching across all major cities.','We manage tenant screening, lease agreements and rent collection so landlords can rent with confidence and tenants find the right home quickly.',2,1),
(3,'Property Management','property-management','briefcase','Full-service management for landlords who want a hands-off experience.','From maintenance coordination to rent collection and tenant communication, our property management service protects your investment year-round.',3,1),
(4,'Investment Consulting','investment-consulting','chart','Data-driven advice to help you invest in Pakistan''s highest-growth areas.','Our advisors analyze market trends, rental yields and capital growth potential to help you build a property portfolio with confidence.',4,1),
(5,'Commercial Real Estate','commercial-real-estate','building','Office, retail and warehouse solutions for growing businesses.','We source and negotiate commercial space that fits your operational needs and budget, from single offices to large industrial facilities.',5,1),
(6,'Property Valuation','property-valuation','calculator','Accurate, market-based valuations for sale, purchase or financing needs.','Our valuation reports combine local market data and comparable sales to give you a reliable estimate of your property''s worth.',6,1);

-- ---------------------------------------------------------------------
-- testimonials
-- ---------------------------------------------------------------------
INSERT INTO `testimonials` (`id`,`client_name`,`photo_media_id`,`designation`,`content`,`rating`,`is_featured`,`is_published`,`sort_order`) VALUES
(1,'Fahad Nadeem',61,'Homeowner, Islamabad','Prime Estates made buying our first house completely stress-free. Ahmed was patient, honest and always available to answer questions.',5,1,1,1),
(2,'Mahnoor Aslam',62,'Investor, Lahore','I''ve purchased three properties through their investment consulting service — every recommendation has outperformed my expectations.',5,1,1,2),
(3,'Zeeshan Iqbal',63,'Tenant, Karachi','Found a great apartment in Clifton within a week. The whole rental process was transparent and quick.',4,0,1,3),
(4,'Hina Yousaf',64,'Business Owner, Islamabad','Usman helped us secure the perfect office space for our growing team. Professional and responsive throughout.',5,1,1,4),
(5,'Kamran Butt',65,'Homeowner, Rawalpindi','Sana found us a rental home that matched every requirement on our list. Highly recommended for anyone relocating to Rawalpindi.',5,0,1,5),
(6,'Sadia Rehman',66,'Seller, Lahore','They sold our DHA property above asking price within a month. Excellent negotiation and marketing.',4,0,1,6);

-- ---------------------------------------------------------------------
-- blog: categories, tags, posts
-- ---------------------------------------------------------------------
INSERT INTO `blog_categories` (`id`,`name`,`slug`) VALUES
(1,'Market Trends','market-trends'),
(2,'Buying Guide','buying-guide'),
(3,'Investment Tips','investment-tips'),
(4,'Area Guides','area-guides');

INSERT INTO `tags` (`id`,`name`,`slug`) VALUES
(1,'Islamabad','islamabad'),
(2,'Investment','investment'),
(3,'First-Time Buyer','first-time-buyer'),
(4,'Rental Tips','rental-tips'),
(5,'2025 Market','2025-market');

INSERT INTO `blog_posts` (`id`,`title`,`slug`,`author_id`,`category_id`,`featured_image_id`,`excerpt`,`content`,`status`,`seo_title`,`seo_description`,`published_at`) VALUES
(1,'5 Things to Check Before Buying a Plot in Islamabad','5-things-to-check-before-buying-a-plot-in-islamabad',1,2,71,'Buying a plot is different from buying a built property — here''s what to verify before you sign anything.','<p>Buying land in Islamabad''s development sectors can be a great long-term investment, but it comes with its own checklist. Before making an offer, verify the plot''s CDA or society approval status, confirm there are no outstanding dues, and check the physical possession matches the file location.</p><p>It''s also worth visiting the site at different times of day to assess noise, access roads and nearby development. Finally, always transfer through a registered dealer and confirm the transfer at the relevant authority to avoid disputes later.</p>','published','5 Things to Check Before Buying a Plot in Islamabad','A practical checklist for verifying approval status, dues and possession before buying a plot in Islamabad.','2025-11-02 09:00:00'),
(2,'2025 Real Estate Trends Shaping Lahore','2025-real-estate-trends-shaping-lahore',1,1,72,'From DHA expansions to rising apartment demand, here''s what''s driving Lahore''s property market this year.','<p>Lahore''s real estate market in 2025 is being shaped by continued expansion of DHA phases, growing demand for vertical living near commercial hubs like Gulberg, and increased interest from overseas Pakistanis investing in ready properties.</p><p>Apartment living, once a niche choice in Lahore, is gaining ground among young professionals who prioritize location and amenities over plot size. Meanwhile, well-located plots in newer DHA phases continue to see steady appreciation.</p>','published','2025 Real Estate Trends Shaping Lahore | Prime Estates','An overview of the trends driving Lahore''s property market in 2025, from DHA growth to rising apartment demand.','2025-11-10 09:00:00'),
(3,'A Beginner''s Guide to Buying Your First Home in Pakistan','a-beginners-guide-to-buying-your-first-home-in-pakistan',1,2,73,'Everything a first-time buyer needs to know, from budgeting to finalizing the transfer.','<p>Buying your first home starts with an honest budget that accounts for the down payment, transfer costs and any renovation needs. Get pre-approved for financing if you plan to use a bank loan, so you know your real price range before you start viewing properties.</p><p>Once you find a property you like, arrange an independent inspection, verify ownership documents with a lawyer, and negotiate confidently using comparable sales data. A good agent will guide you through each of these steps.</p>','published','A Beginner''s Guide to Buying Your First Home in Pakistan','Step-by-step guidance for first-time home buyers in Pakistan, from budgeting to closing the deal.','2025-11-18 09:00:00'),
(4,'Top Investment Areas in Karachi for 2025','top-investment-areas-in-karachi-for-2025',1,3,74,'Where smart investors are putting their money in Karachi this year.','<p>Karachi continues to offer strong rental yields in established areas like Clifton and DHA, while emerging zones such as DHA City and Bahria Town Karachi offer lower entry prices with significant upside as infrastructure develops.</p><p>Commercial corridors near the port and industrial zones also remain attractive for investors seeking warehouse and logistics space, driven by Karachi''s role as Pakistan''s primary trade hub.</p>','published','Top Investment Areas in Karachi for 2025','A look at the Karachi neighborhoods offering the strongest rental yields and growth potential in 2025.','2025-11-25 09:00:00'),
(5,'Renting vs Buying: What Makes Sense in Rawalpindi','renting-vs-buying-what-makes-sense-in-rawalpindi',1,3,75,'A practical comparison to help you decide whether to rent or buy in Rawalpindi right now.','<p>Renting offers flexibility and lower upfront costs, making it a sensible choice if you expect to relocate within a few years. Buying makes more sense if you plan to stay long-term and want to build equity, especially in growing areas like Bahria Town Rawalpindi.</p><p>Compare the total cost of renting versus the mortgage, maintenance and transfer costs of buying over your expected time horizon before deciding.</p>','published','Renting vs Buying: What Makes Sense in Rawalpindi','Weighing the costs and benefits of renting versus buying property in Rawalpindi.','2025-12-01 09:00:00'),
(6,'Understanding Property Taxes and Transfer Costs in Pakistan','understanding-property-taxes-and-transfer-costs-in-pakistan',1,2,76,'A clear breakdown of the taxes and fees involved when buying or selling property in Pakistan.','<p>Property transactions in Pakistan involve several costs beyond the sale price, including stamp duty, capital value tax, registration fees and, in some cases, capital gains tax on the seller''s side. These vary by province and property type.</p><p>Working with an experienced agent or lawyer ensures these costs are calculated correctly and factored into your offer from the start, avoiding surprises at transfer time.</p>','published','Understanding Property Taxes and Transfer Costs in Pakistan','A guide to the stamp duty, CVT, registration fees and other costs involved in Pakistani property transactions.','2025-12-08 09:00:00');

INSERT INTO `blog_post_tags` (`blog_post_id`,`tag_id`) VALUES
(1,1),(1,3),
(2,1),(2,5),
(3,3),(3,2),
(4,2),(4,5),
(5,4),(5,2),
(6,3),(6,2);

-- ---------------------------------------------------------------------
-- menus
-- ---------------------------------------------------------------------
INSERT INTO `menus` (`id`,`location`,`label`,`url`,`sort_order`,`target`,`parent_id`,`is_active`) VALUES
(1,'header','Home','/',1,'_self',NULL,1),
(2,'header','Properties','/properties',2,'_self',NULL,1),
(3,'header','Buy','/buy',3,'_self',NULL,1),
(4,'header','Rent','/rent',4,'_self',NULL,1),
(5,'header','Projects','/projects',5,'_self',NULL,1),
(6,'header','About','/about-us',6,'_self',NULL,1),
(7,'header','Contact','/contact',7,'_self',NULL,1),
(8,'footer','Properties','/properties',1,'_self',NULL,1),
(9,'footer','Buy','/buy',2,'_self',NULL,1),
(10,'footer','Rent','/rent',3,'_self',NULL,1),
(11,'footer','Projects','/projects',4,'_self',NULL,1),
(12,'footer','Blog','/blog',5,'_self',NULL,1),
(13,'footer','Agents','/agents',6,'_self',NULL,1),
(14,'footer','About Us','/about-us',7,'_self',NULL,1),
(15,'footer','Contact','/contact',8,'_self',NULL,1);

-- ---------------------------------------------------------------------
-- pages / page_sections
-- ---------------------------------------------------------------------
INSERT INTO `pages` (`id`,`slug`,`title`,`seo_title`,`seo_description`,`status`) VALUES
(1,'home','Home','Prime Estates — Find Your Perfect Place in Pakistan','Browse verified houses, apartments, plots and commercial properties for sale and rent across Pakistan.','published'),
(2,'about-us','About Us','About Prime Estates','Learn about Prime Estates, our mission, and the team helping clients buy, sell and rent property across Pakistan.','published'),
(3,'buy','Buy','Buy Property in Pakistan | Prime Estates','Browse properties for sale across Islamabad, Rawalpindi, Lahore and Karachi.','published'),
(4,'rent','Rent','Rent Property in Pakistan | Prime Estates','Browse rental properties across Islamabad, Rawalpindi, Lahore and Karachi.','published');

INSERT INTO `page_sections` (`page_id`,`section_type`,`heading`,`subheading`,`content`,`sort_order`,`is_active`) VALUES
(1,'hero','Find a Place You''ll Love to Call Home','Handpicked homes, apartments and plots across Pakistan''s most desirable neighborhoods.',NULL,1,1),
(1,'featured-properties','Featured Properties','A selection of our finest listings, updated regularly.',NULL,2,1),
(1,'property-types','Browse by Property Type',NULL,NULL,3,1),
(1,'why-us','Why Choose Prime Estates','We combine local expertise with a modern, transparent process.',NULL,4,1),
(1,'testimonials','What Our Clients Say',NULL,NULL,5,1),
(1,'cta','Ready to Find Your Next Property?','Talk to our team today and let us help you buy, sell or rent with confidence.',NULL,6,1),

(2,'hero','About Prime Estates','Helping families and investors navigate Pakistan''s property market since day one.',NULL,1,1),
(2,'text','Our Story',NULL,'<p>Prime Estates was founded to bring transparency and professionalism to property transactions across Pakistan. What started as a small team in Islamabad has grown into a trusted name across four major cities, helping thousands of clients buy, sell, rent and invest with confidence.</p><p>We believe finding a home should feel exciting, not overwhelming — so we combine deep local market knowledge with a modern, client-first process at every step.</p>',2,1),
(2,'statistics','Prime Estates in Numbers',NULL,NULL,3,1),
(2,'why-us','Why Clients Choose Us','Local expertise, transparent pricing and a team that listens.',NULL,4,1),
(2,'team','Meet Our Team',NULL,NULL,5,1),
(2,'testimonials','Client Stories',NULL,NULL,6,1),
(2,'cta','Let''s Find Your Next Property',NULL,NULL,7,1),

(3,'hero','Find Your Next Property to Buy','Verified houses, apartments, plots and commercial properties for sale across Pakistan.',NULL,1,1),
(3,'featured-properties','Featured Properties for Sale',NULL,NULL,2,1),
(3,'why-us','The Prime Estates Buying Process',NULL,NULL,3,1),
(3,'cta','Have a Property to Sell?','List it with Prime Estates and reach thousands of verified buyers.',NULL,4,1),

(4,'hero','Find Your Next Rental Home','Verified rental homes and apartments across Pakistan''s top cities.',NULL,1,1),
(4,'featured-properties','Featured Rentals',NULL,NULL,2,1),
(4,'why-us','Why Rent Through Prime Estates',NULL,NULL,3,1),
(4,'cta','Have a Property to Rent Out?','List it with Prime Estates and find a reliable tenant fast.',NULL,4,1);

-- ---------------------------------------------------------------------
-- inquiries / contact_messages (sample demo entries)
-- ---------------------------------------------------------------------
INSERT INTO `inquiries` (`property_id`,`project_id`,`agent_id`,`name`,`phone`,`email`,`message`,`inquiry_type`,`status`,`created_at`) VALUES
(2,NULL,1,'Hamza Sheikh','+923331234567','hamza.sheikh@example.com','I am interested in the 3-bed apartment in Bahria Town. Is it still available?','whatsapp','new','2026-08-05 11:20:00'),
(NULL,1,NULL,'Rabia Anwar','+923214567890','rabia.anwar@example.com','Can you share the payment plan details for Emirates Enclave?','details','new','2026-08-06 15:45:00'),
(11,NULL,2,'Junaid Malik','+923451237890','junaid.malik@example.com','Would like to schedule a visit for the DHA Phase 6 house this weekend.','visit','contacted','2026-08-03 10:05:00');

INSERT INTO `contact_messages` (`name`,`email`,`phone`,`subject`,`message`,`is_read`,`is_contacted`,`created_at`) VALUES
('Nida Farooq','nida.farooq@example.com','+923009876543','General Inquiry','I am relocating to Lahore and would like help finding a 3-bedroom rental near Gulberg.',0,0,'2026-08-07 09:15:00'),
('Tariq Aziz','tariq.aziz@example.com','+923451112223','Selling my property','I want to list my house in DHA Islamabad for sale. Please advise on the process.',1,0,'2026-08-04 13:30:00'),
('Omer Farooq','omer.farooq@example.com',NULL,'Investment advice','Looking for guidance on the best areas in Karachi for rental yield.',1,1,'2026-08-01 08:50:00');

SET FOREIGN_KEY_CHECKS = 1;
