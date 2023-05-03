<?php
    if (!empty($db)) {
        $sql = "SELECT * FROM `event` WHERE user_id = ".$_SESSION['user_id'];

        $statement = $db->prepare($sql);
        if ($statement->execute()) {
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }else{
            echo "<div class='alert alert-danger' role='alert'>Something went wrong</div>";
        }
?>
<div class="events-list border">
    <?php
        if (count($result) === 0){
            echo "<div class='alert alert-info' role='alert'>You haven't uploaded any event yet.</div>";
        }else{
        ?>
    <table class="table">
        <thead>
        <tr>
            <th>
                <div >#</div>
                <div >Title</div>
            </th>
            <th scope="col">operation</th>
        </tr>
        </thead>
        <tbody>
    <?php
        foreach ($result as $value){
            ?>
            <tr>
                <td>
                    <div><?=$value['id']?></div>
                    <div class="event-info">
                        <img style="border-radius: 50px; object-fit: cover;" width="40" height="40" src="../../api/image/<?=$value['image']?>" alt="<?=$value['title']?>">
                        <?=$value['title']?>
                    </div>
                </td>
                <td class="buttons">
                    <a href='../new_event/?id=<?=$value['id']?>' class='update btn' >update</a>
                    <a href='./delete.php?id=<?=$value['id']?>' class='delete btn' onclick='return confirm("Are you sure you want to delete this event?")'>Delete</a>
                </td>
            </tr>
            <?php
        }
    }
    ?>
    </tbody>
    </table>
    <?php
    }
    ?>
</div>
