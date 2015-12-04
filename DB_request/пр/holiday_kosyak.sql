    --------------------------------------------
      
  Select * from mv_person_otpuska where fperson='8001000000009778'
  --------------------------------
Select a.FLPRIZN,p.ffio,a.fcaddnrec2 from persons p 
    left outer join appointments a on a.fperson=p.fnrec
    where a.fnrec='800100000001E6DD'
--------------------------------------------------------------------------
  
  Select * from persons where FNREC='8001000000009778'
  ----------------------------------------------------------
Select * from holiday where fperson='800100000000878D'

------------------------------------------------------
Select * from holiday where fappoint='8001000000019D8D'
    --------------ƒÓ‰ÂÎ‡Ú¸
 Select fcaddnrec2  from appointments where fnrec='800100000001B988'  

800100000000878D    80010000000203BA


  --------------oooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo
  
  Select * from Holiday h
        left outer join appointments ap on ap.fnrec=h.fappoint
-----wwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww
  Select p.ffio,ap.fnrec,h.fperson,h.fappoint from Holiday h
        left outer join mv_person_otpuska ap on ap.fnrec=h.fappoint
        left outer join persons p on p.fnrec=ap.fperson

------------vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvœ≈–≈Õ¿«Õ¿◊≈Õ»≈ APPOINT ÔÓÒÎÂ ÔÂÂÌÓÒ‡vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv

UPDATE HOLIDAY x set
    x.fappoint = (  Select an.fnrec from appointments ap 
                    inner join appointments an on an.fperson=ap.fperson and an.flprizn=ap.flprizn and an.fdepartment=ap.fdepartment and an.fdismissdate='0'
                     where ap.fdismissdate<>'0'
                     and ap.fnrec=x.fappoint )
      where     
      x.fappoint in (Select ap.fnrec from appointments ap 
                    inner join appointments an on an.fperson=ap.fperson and an.flprizn=ap.flprizn and an.fdepartment=ap.fdepartment and an.fdismissdate='0'
                     where ap.fdismissdate<>'0'
                     and ap.fnrec=x.fappoint)            
    
  -----------vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv¡≈« œŒƒ–¿«ƒ≈À≈Õ»ﬂvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv   
  
  
  UPDATE HOLIDAY x set
    x.fappoint = (  Select an.fnrec from appointments ap 
                    inner join appointments an on an.fperson=ap.fperson and an.flprizn=ap.flprizn  and an.fdismissdate='0'
                     where ap.fdismissdate<>'0'
                     and ap.fnrec=x.fappoint )
      where     
      x.fappoint in (Select ap.fnrec from appointments ap 
                    inner join appointments an on an.fperson=ap.fperson and an.flprizn=ap.flprizn  and an.fdismissdate='0'
                     where ap.fdismissdate<>'0'
                     and ap.fnrec=x.fappoint)  
  -----------------------------------------------------------------------------------------------------------   
                
  
  Select * from appointments ap 
                    inner join appointments an on an.fperson=ap.fperson and an.flprizn=ap.flprizn and an.fdepartment=ap.fdepartment and an.fdismissdate='0'
                     where ap.fdismissdate<>'0'
  
  
       Select * from mv_person_otpuska 
       where fperson='8000000000000159'
       
    create table HOLIDAY_20151113
    as 
    Select * from HOLIDAY   
      
    Delete from HOLIDAY where NREC in (
    )
    
  Select * from(     
   Select h.*,row_number() over (partition by h.fappoint,h.date_beg order by h.fappoint,h.date_beg,h.nrec desc) rn,
   count(*) over (partition by h.fappoint,h.date_beg) cnt
     from Holiday h
    ) where rn>1


Select * from v_holprint_full

Select * from mv_person_otpuska order by FFIO

Select * from HOLIDAY where fperson='8001000000009BDB'


Select * from v_holprint_full where DATE_BEG is null

Select FAPPOINT from v_holprint_full where DATE_BEG is null

Select * from mv_select_person


Select * from V_SP_PODR_RH

select * from MV_PERSON_OTPUSKA where FNREC in ('800100000001FD00','800100000001ACEB','800100000001BBBD','800100000001E84F','800100000001FE56','800100000001F961','800100000001F48C','800100000001F4D2','800100000001F4C0','800100000001E77B','800100000001F498','800100000001E878','800100000001E1E2','800100000001B244','800100000001B248','800100000001B6FC','8001000000020111','800100000001B1F9','800100000001F630','800100000001A50B','800100000001FE84','800100000001F993','800100000001F3DE','800100000001DD64','8001000000020040','800100000001B671','800100000001E8CF','800100000001F29C','800100000001BF80','800100000001B4C6','800100000001F37E','800100000001F982','800100000001F5AA','800100000001F5B9','800100000001F1AA','800100000001BCDC','800100000001E6BD','800100000001B0A6','800100000001E526','800100000001F8BD','800100000001C02E','800100000001D441','8001000000017CB8','800100000001F97B','800100000001F525','800100000001F9C7','800100000001E76B','800100000001E685','800100000001F713','8001000000019D05','800100000001A7D8','800100000001FE40','8001000000017CD8','800100000001FF14','800100000001F5C8','800100000001C6DB','800100000001B0F0','800100000001C5CD','800100000001B379','800100000001FE03','800100000001B380','800100000001C5CB','800100000001B603','800100000001B3A7','800100000001B41B','800100000001FD70','800100000001FEBE','800100000001F915','800100000001F5DF','800100000001C92F','800100000001E96D','8001000000017D54','800100000001F11C','800100000001E820','8001000000017D50','800100000001F27E','800100000001F8B1','800100000001F1BD','8001000000017D52','800100000001EEFB','8001000000019D8D','800100000001E675','800100000001B086')
