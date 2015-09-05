<?php
 $do    = @$_GET['do'];
 $title = @$_GET['title'];
 $ns    = @$_GET['ns'];
 $back  = @$_GET['back'];

 $wikidata="/home/www/wikidata/wiki/pages/";

 // echo $title;

 switch ($do) {
    case "enha":
        $result=fetch_enha($title);
 //       if ($result==null) { header("Location: http://openwiki.kr/?id=$ns:$title&do=edit" ); exit(); }
        $id=$ns.":".clearID($title);

        if ($result!=null  ) : 

             $file= $wikidata.str_replace(':','/',$id).'.txt';
        // echo $file;
        // echo $id;
            if (!file_exists($file))  file_put_contents($file, $result);
        endif;   
        //echo $result;

        break;
    case "namu":
        $result=fetch_namu($title);
 //       if ($result==null) { header("Location: http://openwiki.kr/?id=$ns:$title&do=edit" ); exit(); }
        $id=$ns.":".clearID($title);

        if ($result!=null  ) : 

             $file= $wikidata.str_replace(':','/',$id).'.txt';
       //  echo $file;         echo $id;
            if (!file_exists($file))  file_put_contents($file, $result);
        endif;   
       // echo $result;

        break;
        case "root":
        $id=$title; 
        break;
    case "ns":
        $id=($ns)?$ns.":".$title:$title;
        break;
}

if ($id){
   header("Location: http://openwiki.kr/?id=$id&do=edit" ); exit();
} else  {
    header("Location: http://openwiki.kr/?id=$back" ); exit(); 
}


function clearID($id) {
    $id=trim($id);
    $id=str_replace(' ', '_',$id);
    $id=str_replace('/', '_',$id);
    $id=str_replace(':', '_',$id);
    $id=str_replace('__', '_',$id);
    return strtolower($id);
}
function fetch_namu($title){

    $uri="https://namu.wiki/raw/".str_replace('+', '%20',urlencode($title)); //공백을 %20으로 바꿈.
    //$uri="https://raw.enha.kr/wiki/".(str_replace(' ', '%20',$title)); //공백을 %20으로 바꿈.
    echo $uri;
   # $uri="http://rigvedawiki.net/r1/wiki.php/".str_replace(' ', '%20',$title)."?action=raw"; //공백을 %20으로 바꿈.
    
 

    $raw= @file_get_contents($uri);

    $result=e2d($raw);
    
    //echo $raw; exit;
  
    
    if ( strlen ($result)<500)  return false;

    $result="{{page>틀:펌글}}\n\n======$title======\n\n".$result."\n  * 출처: 나무위키- ".$title."(CC BY-NC-SA 2.0)\n\n{{tag>$title}}\n";  //페이지 제목 추가.
    
    //echo $result; exit;
      
      
    return $result;
}

function fetch_enha($title){

    $uri="https://raw.enha.kr/wiki/".str_replace('+', '%20',urlencode($title)); //공백을 %20으로 바꿈.
    //$uri="https://raw.enha.kr/wiki/".(str_replace(' ', '%20',$title)); //공백을 %20으로 바꿈.
    //echo $uri;
   # $uri="http://rigvedawiki.net/r1/wiki.php/".str_replace(' ', '%20',$title)."?action=raw"; //공백을 %20으로 바꿈.
    
    //$title=str_replace('%20','_',$title);
    
#   $snoopy = new Snoopy;
#   $snoopy->fetch($uri);
#   global $raw;
#     $raw=$snoopy->results;

    $raw= @file_get_contents($uri);

    $result=e2d($raw);
    if ( strlen ($result)<500)  return false;

    $result="{{page>틀:펌글}}\n\n======$title======\n\n".$result."\n  * 출처: 엔하위키미러- ".$title."(CC BY-NC-SA 2.0)\n\n{{tag>엔하위키미러 $title}}\n";  //페이지 제목 추가.
    return $result;
}

function  e2d($raw) {  
    
    //단순 삭제
    $todel=array("[[각주]]","[[목차]]","<:>","<(>","<)>","\r","#blue","#orange","#red","#green");

    $text=str_ireplace($todel,"",$raw); // 필요없는 것 삭제...
    
    //단순 치환
    $torep=array(
        "||"=>"|", //테이블처리 
        "[[추가바람]]" => "[[:추가바람]]",
        "{{{" => "%%",      
        "}}}" => "%%",          
        "[[include(틀:스포일러)]]"    => "{{page>틀:누설}}",
        "[[include(틀:비하적 내용)]]" => "{{page>틀:속된 표현}}",
        "[[include(틀:폭력요소)]]"    => "{{page>틀:폭력성}}",
        "[[include(틀:성적요소)]]"    => "{{page>틀:선정성}}",
        "[[include(틀:편중된 관)]]"    => "{{page>틀:편중된 관점}}",

        "[[BR]]"    => " \\ ",
        "[/"            => "[",
        "[\"/"          => "[\"",
        "%20"           => " ",
        "attachment:" => "http://z4.enha.kr/http://rigvedawiki.net/r1/pds"
    );
    foreach ($torep as $key => $val)
     {
        $text=str_ireplace($key,$val,$text);
     }

    $torep=array(

        "/\n  \* /"=>"\n      * ", // 불릿 처리 
                "/\n \* /"=>"\n    * ", // 불릿 처리 
                
        "/\n\* /"=>"\n  * " // 불릿 처리
    );
    foreach ($torep as $key => $val)
     {
        $text=preg_replace($key,$val,$text);
     }



    $text=preg_replace('/(\n=+.+) /','$1',$text);  //제목뒤의  공백제거
    $text=preg_replace('/(\n=+) /','$1',$text);  //제목엎의  공백제거

    
    $text= preg_replace('/^=====([^=]+)=====/m','뷀뷀$1뷀뷀',$text); //제목처리 h5
    $text= preg_replace('/^====([^=]+)====/m','뷀뷀뷀$1뷀뷀뷀',$text); //제목처리 h4
    $text= preg_replace('/^===([^=]+)===/m','뷀뷀뷀뷀$1뷀뷀뷀뷀',$text); //제목처리 h3
    $text= preg_replace('/^==([^=]+)==/m','뷀뷀뷀뷀뷀$1뷀뷀뷀뷀뷀',$text); //제목처리 h2
    $text= preg_replace('/^=([^=]+)=/m','뷀뷀뷀뷀뷀뷀$1뷀뷀뷀뷀뷀뷀',$text); //제목처리 h1
    
    $text= preg_replace('/뷀/','=',$text); //제목처리
    
  
    
    
    $text= preg_replace("/\n\s\* /im","\n  * ",$text); //그림 처리2

    $text= preg_replace('/http:.+(jpg|gif|bmp|png|jpeg)/i','{{$0}}',$text); //그림 처리2
    $text= preg_replace('/\??width=[0-9]*/i','',$text); // width 처리
    $text= preg_replace('/\??height=[0-9]*/i','',$text); // height 처리
    $text= preg_replace('/&{0,1}align=right|left|middle/i','',$text); // align 처리

    //구문강조 처리   
    $text= preg_replace('/\'\'\'([^\'\'\']+)\'\'\'/','**$1**',$text); //굵게''' 처리
    $text= preg_replace('/\'\'([^\'\']+)\'\'/','**$1**',$text); //기울이기'' 처리
    if (!empty($_POST['chk_info']) && (!$chk_info[1])) {$text= preg_replace('/~~([^~~]+)~~/','<del>$1</del>',$text);} //''' 처리  
                else {$text= preg_replace('/~~([^~~]+)~~/','',$text);}
    //$text=preg_replace("~.+a","ㅁ",$text);
    //$text=preg_replace("(\=+)","$0=",$text);
    //$text=preg_replace("(\=+)","$0=",$text); //제목줄처리.
    
     
    //링크처리
    //도쿠위키는 링크[[]]안의 ""를 무시하기 때문에 건드릴 필요가 없다. 
    $text= preg_replace('/(\[[^\[|^\*][^\]]+\])([^\]])/','[$1]$2',$text); //  홀대괄호 링크처리

    $text= preg_replace('/\[wiki\:/i','[',$text); // [wiki: 는 [로


    //$text= preg_replace('/ \["([^\[]+)\]/','[["$1]]',$text); // [" "]를 [[ ]]
    $text= preg_replace('/\[\[(https?:[^ "\[]+) ([^\[]+)\]\]/','[[$1|$2]]',$text); // [[xx yy]]
    $text= preg_replace('/\[\["(.+)"(.+)\]\]/','[[$1|$2]]',$text); // [["ㅌㅌㅌ"  ㅊㅊㅊ ]]
    
    $text= preg_replace('/<[^>]+>/','',$text); // 각종 태그 처리.
    
    $text= preg_replace('/\{\{\|([^\|\}\}]+)\|\}\}/','<box 80% round blue>$1</box>',$text); // 상자   
    
    // 지랄맞은 주석처리
    $text= preg_replace('/\[\[/','뷀뷀',$text); 
    $text= preg_replace('/\]\]/','뷈뷈',$text); 
    $text= preg_replace('/\[\*([^\]]*)\]/','(($1))',$text); // 마침내 주석처리..
    $text= preg_replace('/뷀뷀/','[[',$text); 
    $text= preg_replace('/뷈뷈/',']]',$text); 
    

    //youtbe  

    $text= preg_replace('/\[\[.*youtube[^=]+=(.+)\|([^]]*)\]\]/','{{youtube>$1?640x390}}',$text); 


    $text=preg_replace('/==(.*)\*\*(.*)\*\*(.*)==/','==$1$2$3==',$text);  //제목의 **제거
    $text=preg_replace('/==(.*)\[\[(.*)==/','==$1$2==',$text);  //제목의 [[ ]]제거  
    $text=preg_replace('/==(.*)\]\](.*)==/','==$1$2==',$text);  //제목의 [[ ]]제거  
  


    if ( strlen ($text)<500)      $text=null;
    return $text; 
}


?>