drop type Thesaurus_T force;
drop type Concept_T force;
drop type Terme_T force;
drop type GroupeTermes force;
drop type GroupeConcept force;
drop type refTerm force;
drop type refCon force;


drop table Terme force;
drop table Concept force;
drop table Thesaurus force;
drop table Stat_terme;
drop table Stat_recherche;

--La creation de type Thesaurus_T et le tableau
create type Thesaurus_T as Object
	(
		nom varchar2(50)
	)
/
--La creation de concept
create type Concept_T as Object
(
	nom varchar2(50),
	thesaurusC ref Thesaurus_T, --Pour represanter la liaison 1-* entre concept et thesaurus !!!
	vedette ref Terme_T,
	CG ref Concept_T,
	CS GroupeConcept
)
/
create type refCon as Object
(
	concept ref Concept_T
)
/	

create type GroupeConcept as table of refCon
/
--La creation de la table terme
create type Terme_T as Object
(
	libelle varchar2(50),
	typeT int,
	description varchar2(50),
	TG ref Terme_T,
	TS GroupeTermes,
	TA GroupeTermes,
	Cpts GroupeConcept
)
/

create type refTerm as Object
(
	terme ref Terme_T
)
/

create type GroupeTermes as table of  refTerm 
/

create table thesaurus of Thesaurus_t
(
	constraint pk_thesaurus primary key(nom)
);

create table Concept of Concept_T
(
	constraint pk_concept primary key(nom)
)
nested table CS store as CS_TAB;

create table Stat_terme
(
	libelle varchar(20),
	nbvisite integer
);

create table Stat_recherche
(
	mot_rech varchar(20),
	nbrech integer 
);
	

create table Terme of Terme_T
(	
	constraint pk_terme primary key(libelle)
) 
nested table TS store as TS_TAB,
nested table TA store as TA_TAB,
nested table Cpts store as Concept_TAB,
;
	