
(() => {
    let sec = 5;
    let time_element = document.getElementById('v-count_time');    

    if(time_element === null) return;    
    
    let time = setInterval(() => {      
        if(sec <= 0){
            document.getElementById('link_vote').click()
            clearInterval(sec);
            return;
        }
        
        sec--;
        time_element.innerHTML = sec;
    }, 1000)
})();