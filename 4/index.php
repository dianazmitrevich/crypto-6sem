<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="main.css">
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
</head>
<body>
    <div class="task-wrap">
        <div class="task">
            <p>Шифр Цезаря</p>
            <form class="caesar-form">
                <textarea name="text" placeholder="Текст">Study of cryptographic ciphers based on substitution of symbols</textarea>
                <input name="keyword" type="text" value="Zmitrevich">
                <button type="submit">Вперед</button>
            </form>
            <div class="encrypted"></div>
            <div class="decrypted"></div>
        </div>
        <div class="symbols-wrap">
            <div class="symbols-enc"></div>
            <div class="symbols-dec"></div>
        </div>
    </div>
    <div class="task-wrap">
        <div class="task">
            <p>Таблица Трисемуса</p>
            <form class="trisemus-form">
                <textarea name="text" placeholder="Текст">Study of cryptographic ciphers based on substitution of symbols</textarea>
                <input name="keyword" type="text" value="Diana">
                <button type="submit">Вперед</button>
            </form>
            <div class="encrypted"></div>
            <div class="decrypted"></div>
        </div>
        <div class="symbols-wrap">
            <div class="symbols-enc"></div>
            <div class="symbols-dec"></div>
        </div>
    </div>

    <script>
        $(".caesar-form").submit(function(e) {
            e.preventDefault();
            let form = $(this);
            $.ajax({
                url: "./caesar.php",
                type: "POST",
                data: form.serialize(),
                success: function (e) {
                    let res = JSON.parse(e);

                    document.querySelectorAll(".encrypted")[0].innerHTML = res["enc"]["text"] + "<br>Время: " + res["enc"]["time"];
                    document.querySelectorAll(".decrypted")[0].innerHTML = res["dec"]["text"] + "<br>Время: " + res["dec"]["time"];
                    document.querySelectorAll(".symbols-enc")[0].innerHTML = res["enc"]['sym'];
                    document.querySelectorAll(".symbols-dec")[0].innerHTML = res["dec"]['sym'];
                },
                error: function () {
                    alert("message was not sent");
                }
            });
        });

        $(".trisemus-form").submit(function(e) {
            e.preventDefault();
            let form = $(this);
            $.ajax({
                url: "./trisemus.php",
                type: "POST",
                data: form.serialize(),
                success: function (e) {
                    let res = JSON.parse(e);

                    document.querySelectorAll(".encrypted")[1].innerHTML = res["enc"]['text'] + "<br>Время: " + res["enc"]["time"];
                    document.querySelectorAll(".decrypted")[1].innerHTML = res["dec"]['text'] + "<br>Время: " + res["dec"]["time"];
                    document.querySelectorAll(".symbols-enc")[1].innerHTML = res["enc"]['sym'];
                    document.querySelectorAll(".symbols-dec")[1].innerHTML = res["dec"]['sym'];
                },
                error: function () {
                    alert("message was not sent");
                }
            });
        });
    </script>
</body>
</html>