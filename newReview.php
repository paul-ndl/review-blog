<!DOCTYPE html>
<html lang="fr">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le blog de Pripri</title>
    <link rel="shortcut icon" href="resources/icon.png" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="gestion.css">
    <script src="functions.js"></script>
</head>

<body>
    <!-- List all reviews -->
    <div>
        <form>
            <div class="reviewData">
                Titre :
                <br>
                <input name="title" class="smallInput" type="text">
                <br>
                Auteur : 
                <br>
                <input name="author" class="smallInput" type="text">
                <br>
                Date : 
                <br>
                <input name="date" class="smallInput" type="text">
                <br>
                Type : 
                <br>
                <input name="type" class="smallInput" type="text">
                <br>
                Contenu :
                <br>
                <textarea name="content" class="bigInput"></textarea>
                <br>
                <input name="submit_date" class="submit_date smallInput" type="date" value="">
                <br>
                <input name="submit_time" class="submit_time smallInput" type="time" value="" step="2">
            </div>
        </form>
        <br>
        <button class="add" onclick="createReview();">Ajouter la review</button>
    <div>

    <br>
    <br>

    <script type="text/javascript">
        now = new Date();
        time = document.querySelector(".submit_time");
        date = document.querySelector(".submit_date");
        month = now.getMonth() > 8 ? (now.getMonth()+1).toString() : "0" + (now.getMonth()+1).toString();
        date.setAttribute("value", "20" + now.getYear().toString().substr(1) + "-" + month + "-" + now.getDate());
        time.setAttribute("value", now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds());
        function createReview() {
            if (confirm("Es-tu sûre de vouloir ajouter cette review?")) {
                element = new FormData(document.querySelector("form"));
                title = element.get('title');
                author = element.get('author');
                date = element.get('date');
                type = element.get('type');
                content = element.get('content');
                submit_date = element.get('submit_date');
                submit_time = element.get('submit_time');
                if (title == "" || author == "" || date == "" || type == "" || content == "") {
                    confirm("Vérifiez que vous avez rempli tous les champs obligatoires!")
                } else {
                    fetch("createReview.php?title=" + title + "&author=" + author + "&date=" + date + "&type=" + type + "&content=" + content + "&submit_time=" + submit_date + " " + submit_time)
                    .then(() => document.location.href = "gestion.php");
                }
                return false;
            }
        }
    </script>
    
</body>
</html>