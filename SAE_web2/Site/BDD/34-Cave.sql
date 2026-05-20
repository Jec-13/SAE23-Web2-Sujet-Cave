
CREATE TABLE IF NOT EXISTS "vins" (
	"noV"	VARCHAR(5) NOT NULL PRIMARY KEY ,
	"CRU"	VARCHAR(20)  NOT NULL,
	"COULEUR"	VARCHAR(20) NOT NULL DEFAULT 'Rouge',
	"ORIGINE"	VARCHAR(15)  NULL
);
CREATE TABLE IF NOT EXISTS "negociants" (
	"noN"	VARCHAR(5) NOT NULL PRIMARY KEY,
	"NOM"	VARCHAR(12) DEFAULT NULL,
	"REGION"	VARCHAR(15) DEFAULT NULL
);
CREATE TABLE IF NOT EXISTS "cave" (
	"noV"	VARCHAR(5) NOT NULL ,
	"noN"	VARCHAR(5) NOT NULL ,
	"NB_BOUTEILLES"	decimal(10 , 0) NOT NULL,
	PRIMARY KEY("noV","noN"),
	
  CONSTRAINT fk_Vins FOREIGN KEY (noV) REFERENCES vins (noV) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_Negociants FOREIGN KEY (noN) REFERENCES negociants (noN) ON DELETE CASCADE ON UPDATE CASCADE
);
INSERT INTO "vins" ("noV","CRU","COULEUR","ORIGINE") VALUES ('V1','Beaujolais','Rouge','Bourgogne');
INSERT INTO "vins" ("noV","CRU","COULEUR","ORIGINE") VALUES ('V10','Sancerre','Rosé','Loire');
INSERT INTO "vins" ("noV","CRU","COULEUR","ORIGINE") VALUES ('V2','Chablis','Blanc','Bourgogne');
INSERT INTO "vins" ("noV","CRU","COULEUR","ORIGINE") VALUES ('V3','Médoc','Rouge','Bordeaux');
INSERT INTO "vins" ("noV","CRU","COULEUR","ORIGINE") VALUES ('V4','St-Emilion','Rouge','Bordeaux');
INSERT INTO "vins" ("noV","CRU","COULEUR","ORIGINE") VALUES ('V5','Sauterne','Blanc','Bordeaux');
INSERT INTO "vins" ("noV","CRU","COULEUR","ORIGINE") VALUES ('V6','Chateauneuf du Pape','Rouge','Côtes du Rhône');
INSERT INTO "vins" ("noV","CRU","COULEUR","ORIGINE") VALUES ('V7','Tavel','Rosé','Côtes du Rhône');
INSERT INTO "vins" ("noV","CRU","COULEUR","ORIGINE") VALUES ('V8','Gewurztraminer','Blanc','Alsace');
INSERT INTO "vins" ("noV","CRU","COULEUR","ORIGINE") VALUES ('V9','Sancerre','Blanc','Loire');
INSERT INTO "negociants" ("noN","NOM","REGION") VALUES ('N1','NICOLAS','Paris');
INSERT INTO "negociants" ("noN","NOM","REGION") VALUES ('N2','FABRE','Bordeaux');
INSERT INTO "negociants" ("noN","NOM","REGION") VALUES ('N3','HAMON','Paris');
INSERT INTO "negociants" ("noN","NOM","REGION") VALUES ('N4','SCHMIT','Alsace');
INSERT INTO "negociants" ("noN","NOM","REGION") VALUES ('N5','BRIAND','Bordeaux');
INSERT INTO "negociants" ("noN","NOM","REGION") VALUES ('N6','MADEC','Loire');
INSERT INTO "negociants" ("noN","NOM","REGION") VALUES ('N7','NICOLAS','Bourgogne');
INSERT INTO "cave" ("noV","noN","NB_BOUTEILLES") VALUES ('V1','N3',72);
INSERT INTO "cave" ("noV","noN","NB_BOUTEILLES") VALUES ('V10','N1',60);
INSERT INTO "cave" ("noV","noN","NB_BOUTEILLES") VALUES ('V2','N3',84);
INSERT INTO "cave" ("noV","noN","NB_BOUTEILLES") VALUES ('V2','N4',36);
INSERT INTO "cave" ("noV","noN","NB_BOUTEILLES") VALUES ('V3','N2',108);
INSERT INTO "cave" ("noV","noN","NB_BOUTEILLES") VALUES ('V3','N5',84);
INSERT INTO "cave" ("noV","noN","NB_BOUTEILLES") VALUES ('V4','N1',60);
INSERT INTO "cave" ("noV","noN","NB_BOUTEILLES") VALUES ('V4','N2',96);
INSERT INTO "cave" ("noV","noN","NB_BOUTEILLES") VALUES ('V4','N5',48);
INSERT INTO "cave" ("noV","noN","NB_BOUTEILLES") VALUES ('V5','N5',72);
INSERT INTO "cave" ("noV","noN","NB_BOUTEILLES") VALUES ('V6','N7',96);
INSERT INTO "cave" ("noV","noN","NB_BOUTEILLES") VALUES ('V7','N1',108);
INSERT INTO "cave" ("noV","noN","NB_BOUTEILLES") VALUES ('V7','N7',48);
INSERT INTO "cave" ("noV","noN","NB_BOUTEILLES") VALUES ('V8','N4',60);
INSERT INTO "cave" ("noV","noN","NB_BOUTEILLES") VALUES ('V9','N1',72);
INSERT INTO "cave" ("noV","noN","NB_BOUTEILLES") VALUES ('V9','N6',84);

