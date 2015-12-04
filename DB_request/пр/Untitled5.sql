grant select on v_mobile_nagruzka to mobile;

create or replace view V_MOBILE_nagruzka
as
select fwYearEd, 
           case when grouping(nsezon)  = 1 then 'ÈÒÎÃÎ ÇÀ '||to_char(2015) ||'-'||to_char(2015+1)||' Ó×.ÃÎÄ'
                when grouping(ffio) = 1 then 'ÈÒÎÃÎ ÇÀ '||decode(nsezon,1,'ÏÅÐÂÛÉ','ÂÒÎÐÎÉ')||' ÑÅÌÅÑÒÐ'
                else decode(nsezon,1,'Îñåíü','Çèìà') end sezon,                

       c_fnrec fcchair,
       ffio, 
       ud_fname,
       sg_fname,
       fwcourse,
       fistudcount,

       to_char(sum(fwload)) itog
from
(
select    nvl(a.c_fname, np.chair) c_fname,
          nvl(a.c_fnrec, np.cchair) c_fnrec,
          (select c.fname from catalogs c 
           where c.fnrec in (select c.fcparent from catalogs c where c.fnrec=nvl(a.c_fnrec, np.cchair))) c1_fname,
          (select c.fnrec from catalogs c 
           where c.fnrec in (select c.fcparent from catalogs c where c.fnrec=nvl(a.c_fnrec, np.cchair))) c1_fnrec,
          nvl(a.udl_fnrec, np.idload) udl_fnrec,
          nvl(a.fwformed, np.formed) fwformed,
          nvl(a.Nfwformed, decode(np.formed,'Ç',1,'À',8,0)) Nfwformed,
          nvl(a.sezon, decode(np.semester,2,'Â','Î')) sezon,
          nvl(a.Nsezon, np.semester) Nsezon,
          nvl(a.ud_fname, np.dis) ud_fname,
          a.ffacultativ,
          a.sg_cnt,
          nvl(a.sg_fname, np.sgroup) sg_fname,
          nvl(a.fwcourse, np.curs) fwcourse,
          a.fwcurrgrcount,
          a.fwunitedstream,
          nvl(a.fistudcount, np.numstud) fistudcount, 
          nvl(a.utw_fname, np.typework) utw_fname,
          nvl(a.utw_fcode, np.typework_code) utw_fcode,
          a.fdloadall fdloadall1,
          np.dloadall fdloadall2,
          nvl(np.dloadall,a.fdloadall) fdloadall,
          a.fwload fwload1,
          np.wload fwload2,
          nvl(np.wload,a.fwload) fwload, 
          nvl(a.fwtypeload,np.wtypeload) fwtypeload,
          a.fdcontcount,
          count(*) over (partition by nvl(np.fio,' ')||decode(np.pochasovka,1,'(ïî÷àñîâêà)',''), nvl(a.udl_fnrec, np.idload), nvl(a.utw_fcode, np.typework_code)) fdcon,
          nvl(a.fwYearEd, np.wyear) fwYearEd,
          nvl(a.rn1, np.numload) rn1,
          nvl2(np.idload,(select count(*) from u_disciplineload where fnrec=np.idload),1) rn2,
          nvl(np.fio,'')||decode(np.pochasovka,1,'(ïî÷àñîâêà)','') ffio,
          nvl(np.idlecture,0) idlecture,
          nvl(np.pochasovka,0) pochasovka
from          
(
select    c.fname c_fname,
          c.fnrec c_fnrec,
          udl.fnrec udl_fnrec,
          decode(b.fwformed, 0,'Î', 1,'Ç', 8, 'À',b.fwformed) fwformed,
          decode(b.fwformed, 1,1,8,8,0) Nfwformed,
          udl.sezon,
          udl.Nsezon,
          nvl(trim(udl.fsname),trim(udl.fsdiscipname)) ud_fname,
          b.ffacultativ,
          b.cnt sg_cnt,
          b.sg_fname sg_fname,
          udl.fwcourse,
          udl.fwcurrgrcount,
          udl.fwunitedstream,
          udl.fistudcount,
          udl.utw_fname,
          udl.utw_fcode,
          udl.fdload fdloadall,
          case when (TRUNC(udl.fdload/udl.v_cont,2)*udl.v_cont<>udl.fdload) 
                     and (row_number() over (partition by udl.fnrec, udl.utw_fcode order by udl.fnrec, udl.utw_fcode)=1)
               then TRUNC(udl.fdload/udl.v_cont,2)+udl.fdload-TRUNC(udl.fdload/udl.v_cont,2)*udl.v_cont
               else TRUNC(udl.fdload/udl.v_cont,2)
               end fwload,
          udl.fwtypeload,
          udl.v_cont fdcontcount,
          utl.fwYearEd,
          row_number() over (partition by udl.fnrec, udl.utw_fcode order by udl.fnrec, udl.utw_fcode) rn1
from 
    u_teachingload utl
    JOIN
    (select a.*,
            case when (a.fccontingent='8001000000000006' and utw.fcode in ('005','009','39')) then galreport.EZ_contingent(a.fnrec)
                 when (utw.fcode in ('006','007','010','011','18','19','26','27','28','29','30','31','32','33','36','37')) then 1
                 when (a.fccontingent='8001000000000006' and 
                      utw.fcode not in ('005','006','007','009','010','011','18','19','26','27','28','29','30','31','32','33','36','37','39')) then a.fwcurrgrcount
                 when (a.fccontingent='8001000000000000') then 1
                 else a.fdcontcount
            end v_cont,      
             decode(mod(fsemester+1,2)+1, 1,'Î', 'Â') sezon,
             decode(mod(fsemester+1,2)+1, 1,1, 2) Nsezon,
             utw.fname utw_fname,
             utw.fcode utw_fcode
      from u_disciplineload a
             JOIN u_typework utw ON (a.fctypework=utw.fnrec)
    ) udl                                    ON (utl.fnrec=udl.fcloadid and udl.fdload<>0
                                               and utl.fwYearEd=2015 and utl.fwYearEd=2016)
    JOIN catalogs c                          ON (utl.fcchair=c.fnrec)
    JOIN (Select Level as LevelNo from dual connect by Level < 200) a1
                                             ON (udl.v_cont>=a1.LevelNo)
    LEFT OUTER JOIN
    (select fcdiscipline, fcdisciploadid
      from
        (select fcdiscipline, fcdisciploadid, row_number() over (partition by fcdisciploadid order by fcdiscipline) rn from u_disciploadcurr)
      where rn=1
     ) udlc                                  ON (udl.fnrec=udlc.fcdisciploadid)
    LEFT OUTER JOIN u_discipline ud          ON (udlc.fcdiscipline=ud.fnrec)
    LEFT OUTER JOIN galreport.v$load_group b ON (udl.fnrec=b.fnrec)) a
    
    FULL OUTER JOIN 
      (select * from galreport.NagruzkaPPS np
       where np.wYear=2015 or np.wYear=2016) 
       np ON (a.udl_fnrec=np.idload and a.rn1=np.numload)
)
where fwyeared = 2015 
 -- and ffio like 'Áóðëóöêèé Â.Â.'

group by rollup (nsezon, (c_fnrec, ffio, sg_fname, fistudcount, fwtypeload, nfwformed, fwformed, ud_fName, 
                          ffacultativ, fwcourse, fwcurrgrcount, fwyeared, c1_fName, c_fName))
order by nsezon, fwtypeload, nfwformed, ffio, fwcourse, sg_fname, ud_fName

