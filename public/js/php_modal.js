
var isHidden = true;
document.title = "CSO | Login"
function actModalDesu(){
    
    var modal_desu = document.getElementById("modal_desu");

    if(isHidden)
        modal_desu.classList.add('model_show');
    else
        modal_desu.classList.remove('model_show');
        
    isHidden = !isHidden;
}