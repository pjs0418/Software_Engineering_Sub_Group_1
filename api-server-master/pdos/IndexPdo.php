<?php

//READ
function getUsers()
{
    $pdo = pdoSqlConnect();
    $query = "SELECT * from Manager;";

    $st = $pdo->prepare($query);
    //    $st->execute([$param,$param]);
    $st->execute([]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

//READ
function getUserDetail($userIdx)
{
    $pdo = pdoSqlConnect();
    $query = "select * from Users where userIdx = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$userIdx]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];
}

//READ
function isValidUserIdx($userIdx)
{
    $pdo = pdoSqlConnect();
    $query = "select EXISTS(select * from Users where userIdx = ?) exist;";

    $st = $pdo->prepare($query);
    $st->execute([$userIdx]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0]['exist'];
}


function createUser($ID, $pwd, $name)
{
    $pdo = pdoSqlConnect();
    $query = "INSERT INTO Users (ID, pwd, name) VALUES (?,?,?);";

    $st = $pdo->prepare($query);
    $st->execute([$ID, $pwd, $name]);

    $st = null;
    $pdo = null;

}

function isExistManagerID($ID)
{
    $pdo = pdoSqlConnect();
    $query = "select count(1) as exist from Manager where ID = ? AND isDeleted = 'N';";

    $st = $pdo->prepare($query);
    $st->execute([$ID]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0]['exist'];
}

function isValidManager($ID, $password)
{
    $pdo = pdoSqlConnect();
    $query = "select count(1) as exist from Manager where ID = ? AND password = ? AND isDeleted = 'N';";

    $st = $pdo->prepare($query);
    $st->execute([$ID, $password]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0]['exist'];
}

function addBooks($title, $author, $description, $bookCoverImageUrl, $eBookFileUrl, $category, $quantity)
{
    $pdo = pdoSqlConnect();
    $query = "INSERT INTO Book (bookTitle, author, description, bookCoverImageUrl, eBookFileUrl, category, quantity, maxQuantity) VALUES (?,?,?,?,?,?,?,?);";

    $st = $pdo->prepare($query);
    $st->execute([$title, $author, $description, $bookCoverImageUrl, $eBookFileUrl, $category, $quantity, $quantity]);

    $st = null;
    $pdo = null;
}

function getGuestByID($guestIdx)
{
    $pdo = pdoSqlConnect();
    $query = "select *
from (
         select Guest.guestIdx, guestName, phoneNo, email, profileImageUrl, isOverdue
         from Guest
                  inner join(select guestIdx, case when returnDate < date(now()) then 'o' else 'x' end as isOverdue
                             from GuestIssueState) OverdueState
                            on OverdueState.guestIdx = Guest.guestIdx
         where Guest.guestIdx = ?
           AND isDeleted = 'N'
         order by isOverdue
         limit 18446744073709551615) as order_overdue
group by guestIdx;";

    $st = $pdo->prepare($query);
    $st->execute([$guestIdx]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];
}

function getGuestsByName($guestName)
{
    $pdo = pdoSqlConnect();
    $query = "select *
from (
         select Guest.guestIdx, guestName, phoneNo, email, profileImageUrl, isOverdue
         from Guest
                  inner join(select guestIdx, case when returnDate < date(now()) then 'o' else 'x' end as isOverdue
                             from GuestIssueState) OverdueState
                            on OverdueState.guestIdx = Guest.guestIdx
         where Guest.guestName = ?
           AND isDeleted = 'N'
         order by isOverdue
         limit 18446744073709551615) as order_overdue
group by guestIdx;";

    $st = $pdo->prepare($query);
    $st->execute([$guestName]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

function getBooksByAuthor($author)
{
    $pdo = pdoSqlConnect();
    $query = "select bookIdx, bookTitle, author, bookCoverImageUrl, category, quantity
from Book
where author = ?
  and isDeleted = 'N';";

    $st = $pdo->prepare($query);
    $st->execute([$author]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}
// CREATE
//    function addMaintenance($message){
//        $pdo = pdoSqlConnect();
//        $query = "INSERT INTO MAINTENANCE (MESSAGE) VALUES (?);";
//
//        $st = $pdo->prepare($query);
//        $st->execute([$message]);
//
//        $st = null;
//        $pdo = null;
//
//    }


// UPDATE
//    function updateMaintenanceStatus($message, $status, $no){
//        $pdo = pdoSqlConnect();
//        $query = "UPDATE MAINTENANCE
//                        SET MESSAGE = ?,
//                            STATUS  = ?
//                        WHERE NO = ?";
//
//        $st = $pdo->prepare($query);
//        $st->execute([$message, $status, $no]);
//        $st = null;
//        $pdo = null;
//    }

// RETURN BOOLEAN
//    function isRedundantEmail($email){
//        $pdo = pdoSqlConnect();
//        $query = "SELECT EXISTS(SELECT * FROM USER_TB WHERE EMAIL= ?) AS exist;";
//
//
//        $st = $pdo->prepare($query);
//        //    $st->execute([$param,$param]);
//        $st->execute([$email]);
//        $st->setFetchMode(PDO::FETCH_ASSOC);
//        $res = $st->fetchAll();
//
//        $st=null;$pdo = null;
//
//        return intval($res[0]["exist"]);
//
//    }
