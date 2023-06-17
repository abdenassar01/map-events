
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <title>Sign up</title>
    <link rel="icon" href="../../frontend/assets/icons/logo.ico">
</head>
<body>
<?php
include ("../../config/db.php");
session_start();

if (isset($_POST['signup'])){
    if (!empty($db)) {
        $username_verification_stmt = $db->prepare("Select count(*) as 'count' from user where username = :username");
        $username_verification_stmt->bindParam(":username", $_POST['username']);
        $username_verification_stmt->execute();
        if($username_verification_stmt->fetchAll(PDO::FETCH_ASSOC)[0]['count'] > 0){
            echo "<div class='alert alert-danger' role='alert'>username already exist</div>";
        }else{
            $sql = "insert into user (username, password, role, name, lastname, birthdate, place_origine, job, place_resedance, marital_status, education) values (:username, :password, 'USER', :firstname, :lastname, :birthdate, :place_origine, :job, :place_resedance, :marital_status, :education);";

            $password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);

            $statement = $db->prepare($sql);
            $statement->bindParam(":username", $_POST['username']);
            $statement->bindParam(":password", $password_hash);
            $statement->bindParam(":firstname", $_POST['firstname']);
            $statement->bindParam(":lastname", $_POST['lastname']);
            $statement->bindParam(":birthdate", $_POST['birthdate']);
            $statement->bindParam(":job", $_POST['job']);
            $statement->bindParam(":marital_status", $_POST['marital_status']);
            $statement->bindParam(":education", $_POST['education']);
            $statement->bindParam(":place_resedance", $_POST['place_resedance']);
            $statement->bindParam(":place_origine", $_POST['place_origine']);
            try{
                if($statement->execute()){
                    $userstmt = $db->prepare("select * from user where username = :username");
                    $userstmt->bindParam(":username", $_POST['username']);
                    $userstmt->execute();
                    $user = $userstmt->fetchAll(PDO::FETCH_ASSOC)[0];
                    $_SESSION['login'] = $user['name'].' '.$user['lastname'];
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
                    header('Location: ../../');
                }
            }catch (Exception $ex){
                print_r($ex);
                echo "<div class='alert alert-danger' role='alert'>error registering new user".$statement->errorInfo()[2]."</div>";
            }
        }
    }
}
?>
<div class="d-flex mx-auto p-2 gap-10" style="justify-content: space-around; align-items: center; min-height: 100vh; flex-wrap: wrap; gap: 50px; width: 95vw">
    <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" width="350" height="auto" viewBox="0 0 846.13514 772.40917" xmlns:xlink="http://www.w3.org/1999/xlink"><path id="ef8ddbf2-422b-4660-b5cd-bfa08ac6b7d7-265" data-name="Path 2389" d="M988.75746,326.21557l-3.791-1.274,34.8-103.872a63.4,63.4,0,0,0-39.97614-80.256l-.00286-.001h0l-220.072-73.716a63.4,63.4,0,0,0-80.256,39.97609l-.001.00291h0l-190.892,569.85a63.4,63.4,0,0,0,39.9761,80.25605l.0029.001h0l220.067,73.72a63.4,63.4,0,0,0,80.254-39.978h0l131.329-392.04,3.792,1.27Z" transform="translate(-176.93243 -63.79541)" fill="#3f3d56"/><path id="fd0ceacc-b1f5-4281-8e70-8593bae263ea-266" data-name="Path 2390" d="M976.96644,157.26956l-28.726-9.623a22.495,22.495,0,0,1-29.592,22.77l-126.072-42.233a22.495,22.495,0,0,1-9.9-36l-26.83-8.988a47.348,47.348,0,0,0-59.935,29.856l-190.619,569.013a47.348,47.348,0,0,0,29.856,59.935h0l221.127,74.075a47.348,47.348,0,0,0,59.935-29.856h0l190.614-569.014a47.348,47.348,0,0,0-29.8576-59.93488Z" transform="translate(-176.93243 -63.79541)" fill="#fff"/><path id="ff2c3c85-1cba-4c81-ad38-62c498a2a918-267" data-name="Path 2391" d="M921.66645,348.16757l-235.984-79.052a4.614,4.614,0,0,1-2.906-5.834l19.61-58.54a4.614,4.614,0,0,1,5.834-2.906l235.986,79.053a4.614,4.614,0,0,1,2.906,5.834l-19.61,58.538a4.614,4.614,0,0,1-5.834,2.906Zm-214.032-144.582a2.768,2.768,0,0,0-3.5,1.744l-19.61,58.538a2.768,2.768,0,0,0,1.744,3.5l235.985,79.053a2.768,2.768,0,0,0,3.5-1.744l19.613-58.535a2.768,2.768,0,0,0-1.744-3.5Z" transform="translate(-176.93243 -63.79541)" fill="#3f3d56"/><path id="a7bacb06-5dda-4315-86f5-9fde62022a18-268" data-name="Path 2392" d="M844.07942,579.78259l-235.985-79.052a4.614,4.614,0,0,1-2.906-5.834l36.298-108.355a4.614,4.614,0,0,1,5.834-2.906l235.986,79.05a4.614,4.614,0,0,1,2.906,5.834l-36.3,108.357A4.614,4.614,0,0,1,844.07942,579.78259Zm-197.345-194.4a2.768,2.768,0,0,0-3.5,1.744l-36.298,108.355a2.768,2.768,0,0,0,1.744,3.5l235.986,79.053a2.768,2.768,0,0,0,3.5-1.744l36.3-108.357a2.768,2.768,0,0,0-1.744-3.5Z" transform="translate(-176.93243 -63.79541)" fill="#3f3d56"/><path id="a78be333-998c-4fe1-92ac-6c17265b914a-269" data-name="Path 2393" d="M889.46644,438.48056l-104.879-35.139a4.614,4.614,0,0,1-2.906-5.834l19.61-58.538a4.614,4.614,0,0,1,5.834-2.906l104.88208,35.138a4.614,4.614,0,0,1,2.906,5.834l-19.609,58.538A4.614,4.614,0,0,1,889.46644,438.48056Zm-82.927-100.665a2.768,2.768,0,0,0-3.5,1.744l-19.609,58.538a2.768,2.768,0,0,0,1.744,3.5l104.882,35.134a2.768,2.768,0,0,0,3.5-1.744l19.61-58.538a2.768,2.768,0,0,0-1.744-3.5Z" transform="translate(-176.93243 -63.79541)" fill="#e6e6e6"/><path id="b3f2a87a-cc28-4d1a-8acd-979c53a8dd39-270" data-name="Path 2394" d="M665.54542,677.45556l-104.879-35.134a4.614,4.614,0,0,1-2.906-5.834l36.591-109.231a4.614,4.614,0,0,1,5.834-2.906l104.881,35.134a4.614,4.614,0,0,1,2.906,5.834l-36.593,109.231A4.614,4.614,0,0,1,665.54542,677.45556Zm-65.949-151.358a2.768,2.768,0,0,0-3.5,1.744l-36.592,109.231a2.768,2.768,0,0,0,1.744,3.5l104.883,35.135a2.768,2.768,0,0,0,3.5-1.744l36.591-109.231a2.768,2.768,0,0,0-1.744-3.5Z" transform="translate(-176.93243 -63.79541)" fill="#e6e6e6"/><path id="bb07296c-c3fc-491e-8a85-4137ac9f94aa-271" data-name="Path 2395" d="M794.9004,720.78857l-104.883-35.135a4.614,4.614,0,0,1-2.906-5.834l36.591-109.231a4.614,4.614,0,0,1,5.834-2.906l104.883,35.135a4.614,4.614,0,0,1,2.906,5.834l-36.59094,109.23A4.614,4.614,0,0,1,794.9004,720.78857Zm-65.949-151.358a2.768,2.768,0,0,0-3.5,1.744l-36.592,109.231a2.768,2.768,0,0,0,1.744,3.5l104.88293,35.136a2.768,2.768,0,0,0,3.5-1.744l36.591-109.231a2.768,2.768,0,0,0-1.744-3.5Z" transform="translate(-176.93243 -63.79541)" fill="#e6e6e6"/><circle id="a320c467-7a2a-401b-bd10-29e63d92c9f6" data-name="Ellipse 477" cx="492.449" cy="369.92014" r="18.774" fill="#0b5ed7"/><path id="b9e531ec-0ab3-46c5-ae54-579cfd03e1f5-272" data-name="Path 2396" d="M714.46644,435.62057a3.12907,3.12907,0,1,0-1.988,5.934l139.869,46.854a3.12907,3.12907,0,1,0,1.988-5.934h0Z" transform="translate(-176.93243 -63.79541)" fill="#e6e6e6"/><path id="ad39a0b5-50a7-48f2-b8cb-2db0547457f7-273" data-name="Path 2397" d="M708.50642,453.42157a3.12907,3.12907,0,1,0-1.988,5.934l60.186,20.162a3.12907,3.12907,0,1,0,1.988-5.934h0Z" transform="translate(-176.93243 -63.79541)" fill="#e6e6e6"/><path id="aac09e93-991f-40c6-86d0-b318c2c011d1-274" data-name="Path 2398" d="M644.20546,463.53457c-2.257-.756-4.539-.04-5.087,1.6s.843,3.582,3.1,4.338l192.976,64.645c2.257.756,4.539.04,5.087-1.6s-.843-3.582-3.1-4.338Z" transform="translate(-176.93243 -63.79541)" fill="#e6e6e6"/><path id="f158e8ac-632b-46f0-9cf0-44644e76b9a4-275" data-name="Path 2399" d="M638.24244,481.33657c-2.257-.756-4.539-.04-5.087,1.6s.843,3.582,3.1,4.338l192.976,64.645c2.257.756,4.539.04,5.087-1.6s-.843-3.582-3.1-4.338Z" transform="translate(-176.93243 -63.79541)" fill="#e6e6e6"/><circle id="b837b54e-04c2-4911-922a-03186401a785" data-name="Ellipse 478" cx="557.43997" cy="181.71815" r="18.774" fill="#0b5ed7"/><path id="b88d563f-8e66-4064-9d4c-186cef5c87ad-276" data-name="Path 2400" d="M779.45942,247.41757a3.12907,3.12907,0,1,0-1.988,5.934h0l139.869,46.854a3.12907,3.12907,0,1,0,1.988-5.934h0Z" transform="translate(-176.93243 -63.79541)" fill="#e6e6e6"/><path id="b990f7ae-58a3-4b3d-8dda-750e08426c01-277" data-name="Path 2401" d="M773.49641,265.21957a3.12907,3.12907,0,1,0-1.988,5.934l60.186,20.162a3.12907,3.12907,0,1,0,1.988-5.934Z" transform="translate(-176.93243 -63.79541)" fill="#e6e6e6"/><path id="a3d5ec06-af2b-4b16-90b4-10a3978e7f3c-278" data-name="Path 2402" d="M760.01942,395.12756l-98.389-32.959,36.589-32.349a4.986,4.986,0,0,1,8.19,2.743l4.152,20.446,26.577-23.5a6.243,6.243,0,0,1,10.253,3.435Zm-94.776-33.693,92.334,30.931-11.993-59.051a4.4,4.4,0,0,0-7.225-2.42l-28.969,25.611-4.788-23.575a3.142,3.142,0,0,0-5.161-1.729Z" transform="translate(-176.93243 -63.79541)" fill="#e6e6e6"/><path id="ad2d9a36-cccf-4762-a8b2-ae4cbcf1fc8d-279" data-name="Path 2404" d="M760.11543,395.14755l-104.882-35.134a4.614,4.614,0,0,1-2.906-5.834l19.609-58.538a4.614,4.614,0,0,1,5.834-2.906l104.883,35.135a4.614,4.614,0,0,1,2.906,5.834l-19.61,58.537a4.614,4.614,0,0,1-5.834,2.906Zm-82.93-100.665a2.768,2.768,0,0,0-3.5,1.744l-19.609,58.538a2.768,2.768,0,0,0,1.744,3.5l104.883,35.135a2.768,2.768,0,0,0,3.5-1.744l19.61-58.538a2.768,2.768,0,0,0-1.744-3.5Z" transform="translate(-176.93243 -63.79541)" fill="#e6e6e6"/><path id="ff89cf89-8b1b-4dc3-86a1-ad04f586c716-280" data-name="Path 2405" d="M614.98445,554.36157a3.12908,3.12908,0,1,0-1.988,5.934l60.186,20.162a3.12908,3.12908,0,0,0,1.988-5.934Z" transform="translate(-176.93243 -63.79541)" fill="#e6e6e6"/><path id="bdb6c5c0-7147-4e18-95bd-6c2e13251f4c-281" data-name="Path 2406" d="M609.12843,571.84155a3.12908,3.12908,0,1,0-1.988,5.934h0l60.187,20.166a3.12909,3.12909,0,0,0,1.988-5.934Z" transform="translate(-176.93243 -63.79541)" fill="#e6e6e6"/><path id="e711c4eb-2570-4817-927e-bed9d0e120e8-282" data-name="Path 2408" d="M780.09742,690.77655a3.12908,3.12908,0,0,0,1.988-5.934l-60.186-20.162a3.12908,3.12908,0,0,0-1.988,5.934Z" transform="translate(-176.93243 -63.79541)" fill="#e6e6e6"/><path id="ac126517-37f4-4549-a663-190a6b7a92b8-283" data-name="Path 2409" d="M785.95344,673.29559a3.12908,3.12908,0,1,0,1.988-5.934l-60.186-20.162a3.12908,3.12908,0,1,0-1.988,5.934Z" transform="translate(-176.93243 -63.79541)" fill="#e6e6e6"/><path id="b0744aa1-6c52-44f5-8f87-5c835d602c4a-284" data-name="Path 2409" d="M879.95344,393.29559a3.12908,3.12908,0,1,0,1.988-5.934l-60.186-20.162a3.12908,3.12908,0,1,0-1.988,5.934Z" transform="translate(-176.93243 -63.79541)" fill="#e6e6e6"/><path id="f9fb24f1-195d-4908-aecd-a74b480672b4-285" data-name="Path 2409" d="M874.95344,407.29559a3.12908,3.12908,0,1,0,1.988-5.934l-60.186-20.162a3.12908,3.12908,0,1,0-1.988,5.934Z" transform="translate(-176.93243 -63.79541)" fill="#e6e6e6"/><g id="fb1fd747-6b67-4cb9-858c-4d0f6fa12359" data-name="Group 161"><circle id="a5dd78ed-2df1-42f3-9bac-4ba46f4211fe" data-name="Ellipse 476" cx="193.98999" cy="277.19815" r="31.83" fill="#9f616a"/><path id="f00778a4-99fe-4ded-96db-b98a687eaf54-286" data-name="Path 2387" d="M352.52343,344.93155c2.523-.151,4.987.7,7.493,1.035,8.965,1.19,18.29-5.315,20.27-14.139a10.84845,10.84845,0,0,1,1.037-3.378c1.38-2.253,4.522-2.682,7.112-2.164s5.046,1.73,7.684,1.869c4.073.214,7.983-2.294,10.154-5.747a19.48818,19.48818,0,0,0,2.492-11.77l-1.953,2.049a9.91821,9.91821,0,0,1-.884-5.39,6.255,6.255,0,0,0-5.925,1.516c-1.722.183-.422-3.193-1.7-4.36a2.959,2.959,0,0,0-2.082-.389c-3.663.035-6.626-2.766-9.512-5.021a40.42031,40.42031,0,0,0-17.071-7.787c-4.136-.807-8.534-.936-12.456.6a26.60866,26.60866,0,0,0-8.412,5.967c-6.141,5.9-11.579,12.843-14.133,20.97a35.30019,35.30019,0,0,0-.169,20.47c1.029,3.474,4.132,15.373,8.674,15.65C348.84542,355.26355,345.42043,345.35556,352.52343,344.93155Z" transform="translate(-176.93243 -63.79541)" fill="#2f2e41"/><path id="edf96d50-4ce8-4ce1-a197-c1cb2bbecc75-287" data-name="Path 111" d="M308.44643,595.83955a14.64,14.64,0,0,0,2.154-22.345l5.679-126.767-28.913,3.245,1.68,124a14.72,14.72,0,0,0,19.4,21.871Z" transform="translate(-176.93243 -63.79541)" fill="#a0616a"/><path id="a7c32b38-e526-409e-9958-50b8ffad01a0-288" data-name="Path 112" d="M361.19143,810.42757l16.456,2.893,16.264-62.1-21.561-4.27Z" transform="translate(-176.93243 -63.79541)" fill="#a0616a"/><path id="b6720e1c-54ee-4da4-8e92-2cd2033f0b28-289" data-name="Path 113" d="M406.58244,834.20455l-51.72334-9.13692,3.53011-19.98368,31.73966,5.6068a20.29309,20.29309,0,0,1,16.45357,23.5138Z" transform="translate(-176.93243 -63.79541)" fill="#2f2e41"/><path id="aff6290b-fbd1-41c3-8a68-a3ddd60c11e3-290" data-name="Path 114" d="M316.02444,818.66556h16.707l7.948-64.445h-24.658Z" transform="translate(-176.93243 -63.79541)" fill="#a0616a"/><path id="f02f1576-8f9c-43fb-a0f1-30b59e5759a8-291" data-name="Path 115" d="M364.93943,834.17958h-52.511v-20.288h32.223a20.288,20.288,0,0,1,20.288,20.288Z" transform="translate(-176.93243 -63.79541)" fill="#2f2e41"/><path id="b96fab23-cef4-43fc-8373-5902972d74dd-292" data-name="Path 116" d="M385.73442,795.56653a6.45519,6.45519,0,0,1-.78-.046l-19.666-1.618a6.651,6.651,0,0,1-5.8294-7.38171q.0195-.16617.04739-.3313l19.528-96.32593-12.27-64.7a2.217,2.217,0,0,0-4.387.218l-18.069,164.396a6.71,6.71,0,0,1-7.1,6.047l-18.527-.69a6.661,6.661,0,0,1-6.182-6.311l1.48-198.656,96.055-12.006,6.71,103.63-.027.11-24.52,108.583A6.658,6.658,0,0,1,385.73442,795.56653Z" transform="translate(-176.93243 -63.79541)" fill="#2f2e41"/><path id="b76097f2-52bd-497e-a273-af776f029639-293" data-name="Path 117" d="M377.18642,605.28556a27.40694,27.40694,0,0,1-14.8-4.233c-16.214-10.134-34.63-6.106-44.165-2.8a6.65106,6.65106,0,0,1-5.752-.655,6.55605,6.55605,0,0,1-3.031-4.84l-17.335-154.856c-2.906-25.945,12.723-50.338,37.161-58h0q1.377-.432,2.8-.819a53.92592,53.92592,0,0,1,44.935,7.8,54.791,54.791,0,0,1,23.4,40l14.6,155.89a6.55193,6.55193,0,0,1-2.087,5.461C407.79543,592.96757,392.94445,605.28355,377.18642,605.28556Z" transform="translate(-176.93243 -63.79541)" fill="#0b5ed7"/><path id="b7c0fd9c-4296-4103-8950-cd245101458a-294" data-name="Path 118" d="M324.38942,471.10755l-39.118-4.3a7.792,7.792,0,0,1-6.685-9.722l9.957-37.95a21.64,21.64,0,1,1,43.03363,4.61126q-.01308.12246-.02761.24472l1.478,39.079a7.792,7.792,0,0,1-8.638,8.037Z" transform="translate(-176.93243 -63.79541)" fill="#0b5ed7"/><path id="e4415faf-95a5-4fec-be4a-0e91d9da7267-295" data-name="Path 119" d="M414.83642,590.41155a14.63993,14.63993,0,0,0-.553-22.443l-9.639-126.527-28.331,6.378,16.631,123.21805a14.72,14.72,0,0,0,21.893,19.374Z" transform="translate(-176.93243 -63.79541)" fill="#a0616a"/><path id="bebc4112-7456-4b85-95f3-28c2273ba549-296" data-name="Path 120" d="M365.45042,463.15358a7.783,7.783,0,0,1-2.478-6l1.478-39.079a21.64,21.64,0,0,1,43.006-4.856l9.957,37.95a7.79211,7.79211,0,0,1-6.685,9.722l-39.118,4.3a7.783,7.783,0,0,1-6.16-2.041Z" transform="translate(-176.93243 -63.79541)" fill="#0b5ed7"/></g><rect id="a6aa4d97-c7f3-4c66-8fef-1a835a984f6d" data-name="Rectangle 256" y="770.40917" width="738.21997" height="2" fill="#cacaca"/></svg>
    <form action="#" method="POST">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <label class="form-label" for="firstname">Name: </label>
                <input type="text" id="firstname" name="firstname" class="form-control full-width" required />
            </div>
            <div class="col-lg-6 col-md-12">
                <label class="form-label" for="lastname">Lastname: </label>
                <input type="text" id="lastname" name="lastname" class="form-control full-width" required />
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-12">
                <label class="form-label" for="place_origine">place of origin: </label>
                <input type="text" id="place_origine" name="place_origine" class="form-control full-width" />
            </div>
            <div class="col-lg-6 col-md-12">
                <label class="form-label" for="birthdate">Date of birth: </label>
                <input type="date" id="birthdate" name="birthdate" class="form-control full-width" />
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-12">
                <label class="form-label" for="place_resedance">Current place of residence: </label>
                <input type="text" id="place_resedance" name="place_resedance" class="form-control full-width" />
            </div>
            <div class="col-lg-6 col-md-12">
                <label class="form-label" for="education">Education: </label>
                <select name="education" class="form-select full-width" id="education">
                    <option selected value="bac">Bac</option>
                    <option value="deploma">Bac + 2 (Deploma)</option>
                    <option value="licence">Bac + 3 (Licence)</option>
                    <option value="master">Bac + 5 (Master)</option>
                    <option value="5">Other</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-12">
                <label class="form-label" for="marital_status">marital status: </label>
                <select class="form-select full-width" name="marital_status" id="marital_status">
                    <option selected value="married">Married</option>
                    <option value="single">Single</option>
                    <option value="divorced">Divorced</option>
                    <option value="widowed">Widowed</option>
                </select>
            </div>
            <div class="col-lg-6 col-md-12">
                <label class="form-label" for="job">Job: </label>
                <input type="text" id="job" name="job" class="form-control full-width" />
            </div>

        </div>

        <div class="row">
            <div class="col-lg-6 col-md-12">
                <label class="form-label" for="username">Email address</label>
                <input type="email" id="username" name="username" class="form-control full-width" required />
            </div>

            <div class="col-lg-6 col-md-12">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control full-width" required />
            </div>
        </div>


        <button type="submit" name="signup" class="btn btn-primary btn-block mt-3 col-12">Sign up</button>

        <div class="text-center">
            <p>Already have an account ? <a href="../login">Log in</a></p>
        </div>
    </form>
</div>
</body>
</html>