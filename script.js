/* =========================
   SHOW / HIDE PASSWORD
========================= */

function togglePassword() {

    const password = document.getElementById("password");
    const button = document.querySelector(".show-password");

    if (password.type === "password") {

        password.type = "text";
        button.textContent = "Hide";

    } else {

        password.type = "password";
        button.textContent = "Show";

    }
}


/* =========================
   LOGIN
========================= */

const loginForm = document.getElementById("loginForm");

if (loginForm) {

    loginForm.addEventListener("submit", function(event) {

        event.preventDefault();

        const username =
            document.getElementById("username").value.trim();

        const password =
            document.getElementById("password").value.trim();

        const message =
            document.getElementById("loginMessage");


        if (username === "" || password === "") {

            message.textContent =
                "Please enter your username and password.";

            return;

        }


        /*
         FRONTEND DEMO ONLY.

         Later PHP will handle real authentication.
        */

        if (username === "admin" && password === "admin123") {

            window.location.href = "dashboard.html";

        } else {

            message.textContent =
                "Invalid username or password.";

        }

    });

}


/* =========================
   SEARCH ASSETS
========================= */

function searchAssets() {

    const input =
        document.getElementById("assetSearch");

    if (!input) {
        return;
    }

    const search =
        input.value.toLowerCase();

    const table =
        document.getElementById("assetsTable");

    const rows =
        table.getElementsByTagName("tbody")[0]
             .getElementsByTagName("tr");


    for (let i = 0; i < rows.length; i++) {

        const rowText =
            rows[i].textContent.toLowerCase();

        if (rowText.includes(search)) {

            rows[i].style.display = "";

        } else {

            rows[i].style.display = "none";

        }

    }

}


/* =========================
   DELETE ASSET DEMO
========================= */

function deleteAsset() {

    const confirmDelete =
        confirm(
            "Are you sure you want to delete this asset?"
        );

    if (confirmDelete) {

        alert("Asset deleted successfully.");

    }

}


/* =========================
   ADD ASSET FORM
========================= */

const assetForm =
    document.getElementById("assetForm");

if (assetForm) {

    assetForm.addEventListener("submit", function(event) {

        event.preventDefault();

        const message =
            document.getElementById("assetMessage");

        message.textContent =
            "Asset saved successfully.";

        message.style.color = "green";

        assetForm.reset();

    });

}