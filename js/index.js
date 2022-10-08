
let delete_btn = document.querySelector(".delete-all")

delete_btn.onclick = () => {
    let a = confirm("Are you sure?")
    if(a) {
        window.location.href = "cart.php?action=delete"
    }
}

