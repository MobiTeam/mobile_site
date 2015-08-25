select * from mv_stud_appoint st
    where instr(
        upper(replace(replace(st.FFIO,'.',''),' ','')),
        upper(replace(replace('Якимчук Александр В.','.',''),' ','')),1)>=1
