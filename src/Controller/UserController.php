<?php 
namespace Controller;

use App\DB;

class UserController {
    function signIn(){
        checkInput();
        extract($_POST);
        
        $user = DB::who($user_id);
        if(!$user || $user->password !== hash('sha256', $password)) back("아이디 혹은 비밀번호가 일치하지 않습니다.");

        $_SESSION['user'] = $user;
        go("/", "로그인 되었습니다.");
    }
    function signUp(){
        checkInput();
        extract($_POST);        

        $exist = DB::who($user_id);
        if($exist) back("중복된 아이디입니다. 다른 아이디를 사용해 주세요.");
        if($capcha_input !== $captcha) back("자동가입방지 문자를 잘못 입력하셨습니다.");

        $photo = $_FILES['photo'];
        $filename = time() . extname($photo['name']);
        dd($filename); // 파일 이름 확인 부탁

        move_uploaded_file($photo['tmp_name'], _UPLOAD.DS."users".DS.$filename);
        
        $params = [$user_id, hash('sha256', $password), $user_name, $filename];
        DB::query("INSERT INTO users (user_id, password, user_name, photo)", $params);

        go("/", "회원가입 되었습니다.");
    }
    function logout(){
        unset($_SESSION['user']);
        go("로그아웃 되었습니다.");
    }

    // 전문가 페이지
    function specialPage(){
        $sql = "SELECT U.*, ifnull(total, 0) total, ifnull(cnt, 0) cnt
                FROM users U
                LEFT JOIN (SELECT COUNT(*) cnt, SUM(score) total, sid FROM user_reviews GROUP BY sid) R ON R.sid = U.id
                WHERE U.type = 1";
        $userList = DB::fetchAll($sql);

        $_myList = DB::fetchAll("SELECT * FROM user_reviews WHERE uid = ?", [user()->id]);
        $myList = [];
        foreach($_myList as $item) $myList[] = $item->sid;

        $sql = "SELECT R.*, U1.user_name, U1.user_id, U2.user_name s_name, U2.user_id s_id
                FROM user_reviews R
                LEFT JOIN users U1 ON U1.id = R.uid
                LEFT JOIN users U2 ON u2.id = R.sid";
        $reviewList = DB::fetchAll($sql);

        view("specailist", ["myList" => $myList, "userList" => $userList, "reviewList" => $reviewList]);
    }
    function reviewSpecialist(){
        checkInput();
        extract($_POST);

        $suser = DB::find("users", $sid);
        if(!$suser) back("해당 유저가 존재하지 않습니다.");
        if(!is_numeric($price) || ! $price || $price < 0) back("올바른 금액을 입력하세요");

        DB::query("INSERT INTO user_reviews(uid, sid, content, price, score) VALUES (?, ?, ?, ?, ?)", [user()->id, $sid, $content, $price, $score]);

        go("/specialists", "리뷰가 작성되었습니다.");
    }
}