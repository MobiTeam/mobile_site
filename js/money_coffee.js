function inp_sum_n(e_field,n_dec){

if("createRange" in document){c_p=e_field.selectionEnd
                              ie=false }
                              else{ie=true}
if(ie){
e_range=e_field.createTextRange()
e_range.expand("character",e_field.value.length)
r=document.selection.createRange()
r.setEndPoint("StartToStart",e_range)
c_p=r.text.length

}
txt=e_field.value
txt1=""
d=0
txt1=""
brd=txt.match(/[.,]/)
if(brd==null){brd=txt.length}else{brd=brd.index}
p_let=""
i_dig=0
for(i=0;i<txt.length;i++){ii=txt.length-1-i
  let=txt.charAt(ii)
  if("0123456789".indexOf(let)>=0){is_digit=true}else{is_digit=false}
  if(is_digit)i_dig++
  if(ii==brd)i_dig=0
  if(ii>=brd){if(is_digit||(ii==brd&&(let=="."||let==","))){txt1=let+txt1}else{if(c_p>ii)c_p--}}
  if(ii<brd){if(is_digit){txt1=let+txt1}else{if(c_p>ii)c_p--}
           if(is_digit&&i_dig%3==0&&i_dig!==0&&ii!==0)
           {txt1=""+txt1;if(c_p>=ii)c_p++} 
           }
}
////////////////////////////////
if(n_dec>0){
  brd=txt1.match(/[.,]/)
  if(brd==null){brd=txt1.length}else{brd=brd.index}
  while(txt1.length-1-brd>n_dec){if(c_p>=txt1.length-1)c_p--
     txt1=txt1.substr(0,txt1.length-1)}
}

e_field.value=txt1
if(ie){r.move("character",c_p)
       r.select()
      }else{e_field.setSelectionRange(c_p,c_p)}

}
