CREATE OR REPLACE FUNCTION AUTHENTICATE_USER
    (p_username in varchar2,
    p_password in varchar2)
return boolean
is
    l_username users.username%type := lower(p_username);
    l_password users.password_hash%type;
    l_hashed_password varchar2(255);
    l_count number;
begin
    select count(*)
    into l_count
    from users
    where username = l_username
    and (user_role = 1 OR user_role = 2);
    
    if l_count > 0 then
        l_hashed_password := lower(dbms_obfuscation_toolkit.md5(
          input => UTL_RAW.cast_to_raw(p_password)));
        
        select password_hash
            into l_password
            from users
            where username = l_username;
            
        if l_hashed_password = l_password then
            APEX_UTIL.SET_AUTHENTICATION_RESULT(0);
            return true;
        else
            APEX_UTIL.SET_AUTHENTICATION_RESULT(4);
            return false;
        end if;
    else
        APEX_UTIL.SET_AUTHENTICATION_RESULT(1);
        return false;
    end if;
    APEX_UTIL.SET_AUTHENTICATION_RESULT(7);
    return false;
exception
    when others then
        APEX_UTIL.SET_AUTHENTICATION_RESULT(7);
        APEX_UTIL.SET_CUSTOM_AUTH_STATUS(sqlerrm);
        return false;
end authenticate_user;
/