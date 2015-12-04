PROCEDURE refresh_cisu_mv
IS
    out_error   BINARY_INTEGER;
BEGIN
    -- ���������� ���������� ������������
    DBMS_UTILITY.analyze_schema ('BUDGET', 'ESTIMATE');
    -- ���������� MV
    DBMS_MVIEW.refresh ('MV_CISU_STUD_APPOINT', 'A');
    DBMS_MVIEW.refresh ('MV_CISU_TEACH_APPOINT', 'A'); 
    DBMS_MVIEW.refresh ('MV_CISU_TIMETABLE', 'A'); 
    DBMS_MVIEW.refresh ('MV_CISU_TIMETABLE_ALL', 'A'); 

END refresh_cisu_mv



