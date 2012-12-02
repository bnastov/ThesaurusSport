-------Thesaurus
insert into Thesaurus values('sport');

-------Concept
insert into Concept values('sport de balle',(select ref(i) from thesaurus i where nom='sport'),null);
insert into Concept values('sport collectif',(select ref(i) from thesaurus i where nom='sport'),null);

-----Terme
insert into Terme values('sport de balle',1,'Tout les sport en balle',null,GroupeTermes(),GroupeTermes(),GroupeConcept());
insert into Terme values('sport collectif',1,'Tout les sport en equipe',null,GroupeTermes(),GroupeTermes(),GroupeConcept());

-------Terme Vedette
update Concept set vedette =(select ref(i) from Terme i where i.libelle='sport de balle') where nom='sport de balle'; 
update Concept set vedette =(select ref(i) from Terme i where i.libelle='sport collectif') where nom='sport collectif';


--------Terme Associé
insert into table(select TA from Terme where libelle='sport de balle') values (refTerm((select ref(i) from terme i where i.libelle='sport collectif')));
insert into table(select TA from Terme where libelle='sport collectif') values (refTerm((select ref(i) from terme i where i.libelle='sport de balle')));


---------Concepts Group
insert into table(select Cpts from Terme where libelle='sport de balle') values (refCon((select ref(i) from concept i where i.nom='sport de balle')));
insert into table(select Cpts from Terme where libelle='sport collectif') values (refCon((select ref(i) from concept i where i.nom='sport collectif')));


-----------------Terme Football, basketball
insert into Terme values('football',0,'le football',null,GroupeTermes(),GroupeTermes(),GroupeConcept());
insert into Terme values('basketball',0,'basketball',null,GroupeTermes(),GroupeTermes(),GroupeConcept());

----TG
update Terme set TG=(select ref(i) from  Terme i  where i.libelle='sport de balle') where libelle='football';
update Terme set TG=(select ref(i) from  Terme i  where i.libelle='sport de balle') where libelle='basketball';


---TA
insert into table(select TA from Terme where libelle='football') values (refTerm((select ref(i) from terme i where i.libelle='basketball')));

---SPORT DE BALLE SPEECIFICATION
insert into table(select TS from Terme where libelle='sport de balle') values (refTerm((select ref(i) from terme i where i.libelle='football')));
insert into table(select TS from Terme where libelle='sport de balle') values (refTerm((select ref(i) from terme i where i.libelle='basketball')));

----Concepts de football et basketball
insert into table(select Cpts from Terme where libelle='football') values (refCon((select ref(i) from concept i where i.nom='sport de balle')));
insert into table(select Cpts from Terme where libelle='football') values (refCon((select ref(i) from concept i where i.nom='sport collectif')));

insert into table(select Cpts from Terme where libelle='basketball') values (refCon((select ref(i) from concept i where i.nom='sport de balle')));
insert into table(select Cpts from Terme where libelle='basketball') values (refCon((select ref(i) from concept i where i.nom='sport collectif')));

----------suppression


------------- TOUT          LESSSSSSSSSSSSSS INSERTTTTTTTTTTTTTTTTTTTTTION POSSSIBLE SON TEST2222222222222222222222222


--------------------LES SELECTION MNT
-----thesaurus
--select * from Thesaurus;


----Concept
--select nom from Concept;
--select deref(thesaurusC) from Concept;
--select deref(vedette) from Concept;-----jspr que sa marche LOL


-----termes
--select libelle, typeT as isvedette from terme;
--select deref(TG).libelle as parent from terme where libelle='football'; 


--select t1.libelle, t1.typeT as isvedette, deref(t1.TG).libelle as parent
	--		from terme t1 
	--		where t1.libelle='football'; 

select deref(t2.concept).nom as parentConcept from  table( select i.Cpts from terme i where  i.libelle='football') t2;
		




