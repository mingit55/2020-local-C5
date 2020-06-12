<?php
namespace Controller;

use App\DB;

class MainController {
    function indexPage(){
        view("index");
    }
    function storePage(){
        view("store");
    }

    // 온라인 집들이
    function partyPage(){
        $sql = "SELECT K.*, user_id, user_name, ifnull(total, 0) total, ifnull(cnt, 0) cnt
                FROM knowhows K
                LEFT JOIN users U ON U.id = K.uid
                LEFT JOIN (SELECT COUNT(*) cnt, SUM(score) total, kid FROM knowhow_reviews GROUP BY kid) R ON R.kid = K.id";
        $knowhows = DB::fetchAll($sql);

        $_myList = DB::fetchAll("SELECT * FROM knowhow_reviews WHERE uid = ?", [user()->id]);
        $myList = [];
        foreach($_myList as $item) $myList[] = $item->kid;

        view("online-party", ['knowhows' => $knowhows, "myList" => $myList]);
    }

    function writeKnowhow(){
        checkInput();
        extract($_POST);
        extract($_FILES);

        $before_ext = extname($before_img['name']);
        $after_ext = extname($after_img['name']);

        $before_name = "before_". time() . $before_ext;
        $after_name = "after_". time() . $after_ext;

        dd($before_name, $after_name); // 업로드전 확인 바람

        move_uploaded_file($before_img['tmp_name'], _UPLOAD.DS."knowhows".DS.$before_name);
        move_uploaded_file($after_img['tmp_name'], _UPLOAD.DS."knowhows".DS.$after_name);

        DB::query("INSERT INTO knowhows(uid, content, before_img, after_img) VALUES (?, ?, ?, ?)", [user()->id, $content, $before_name, $after_name]);
        go("/online-party", "새로운 게시글이 작성되었습니다.");
    }
    
    function reviewKnowhow(){
        checkInput();
        extract($_POST);
        
        $knowhow = DB::find("knowhows", $kid);
        if(!$knowhow) back("해당 게시물이 존재하지 않습니다.");

        DB::query("INSERT INTO knowhow_reviews(uid, kid, score) VALUES(?, ?, ?)", [user()->id, $kid, $score]);
        go("/online-party", "평점이 갱신되었습니다.");
    }

    // 시공 견적 페이지
    function estimatePage(){
        $sql = "SELECT Q.*, user_id, user_name, ifnull(cnt, 0) cnt
                FROM requests Q
                LEFT JOIN users U ON U.id = Q.uid
                LEFT JOIN (SELECT COUNT(*) cnt, qid FROM responses GROUP BY qid) S ON S.qid = Q.id";
        $reqList = DB::fetchAll($sql);

        $_myList = DB::fetchAll("SELECT * FROM responses WHERE uid = ?", [user()->id]);
        $myList = [];
        foreach($_myList as $item) $myList[] = $item->qid;

        $sql = "SELECT S.*, start_date, content, sid, user_name, user_id
                FROM responses S
                LEFT JOIN requests Q ON Q.id = S.qid
                LEFT JOIN users U ON Q.uid = U.id
                WHERE S.uid = ?";
        $resList = DB::fetchAll($sql, [user()->id]);

        view("estimate", ["reqList" => $reqList, "myList" => $myList, "resList" => $resList]);
    }
    function writeRequest(){
        checkInput();
        extract($_POST);

        DB::query("INSERT INTO requests(uid, start_date, content) VALUES (?, ?, ?)", [user()->id, $start_date, $content]);
        go("/estimates", "요청이 완료되었습니다.");
    }
    function writeResponse(){
        checkInput();
        extract($_POST);
        
        $req = DB::find("requests", $qid);
        if(!$req) back("요청을 찾을 수 없습니다.");
        if(!is_numeric($price) || !$price || $price < 0) back("올바른 비용을 입력하세요.");
        
        DB::query("INSERT INTO response(qid, uid, price) VALUES (?, ?, ?)", [$qid, user()->id, $price]);
        go("/estimates", "견적을 보냈습니다.");
    }
    function viewEstimates(){
        if(!isset($_GET['id'])) json_response();

        $req = DB::find("requests", $_GET['id']);
        if(!$req) json_response();

        $list = DB::fetchAll("SELECT S.*, user_id, user_name FROM responses S LEFT JOIN users U ON U.id = S.uid WHERE S.qid = ?", [$req->id]);

        json_response(true, ['list' => $list, 'request' => $req]);
    }

    function pickEstimate(){
        checkInput();
        extract($_POST);
        
        $req = DB::find("requests", $qid);
        $res = DB::find("responses", $sid);

        if(!$req || ! $res) back("요청을 찾을 수 없습니다.");
        
        DB::query("UPDATE requests SET sid = ? WHERE id = ?", [$sid, $qid]);
        go("/estimates", "선택되었습니다.");
    }
}