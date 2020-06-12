<?php
use App\Router;

Router::get("/", "MainController@indexPage");
Router::get("/store", "MainController@storePage");

// 회원 관리
Router::post("/sign-in", "UserController@signIn");
Router::post("/sign-up", "UserController@signUp");
Router::get("/logout", "UserController@logout", "U");

// 온라인 집들이
Router::get("/online-party", "MainController@partyPage");
Router::post("/knowhows", "MainController@writeKnowhow");
Router::post("/knowhows/reviews", "MainController@reviewKnowhow");

// 전문가 페이지
Router::get("/specialists", "UserController@specialPage");
Router::post("/specialists/reviews", "UserController@reviewSpecialist");

// 시공 견적 페이지
Router::get("/estimates", "MainController@estimatePage");
Router::post("/estimates/requests", "MainController@writeRequest");
Router::post("/estimates/responses", "MainController@writeResponse");
Router::get("/estimates/viewer", "MainController@viewEstimates");
Router::post("/estimates/pick", "MainController@pickEstimate");

Router::redirect();