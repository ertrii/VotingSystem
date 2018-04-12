
(() => {
    let sec = 5;
    let time_element = document.getElementById('v-count_time');    
    let link = document.getElementById('v-link_vote');
    if(time_element === null || link === null) return;
    
    let time = setInterval(() => {      
        if(sec <= 0){
            link.click()
            clearInterval(time);
            return;
        }
        
        sec--;
        time_element.innerHTML = sec;
    }, 1000)
})();