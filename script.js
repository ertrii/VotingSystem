
(() => {
    let sec = 5;
    let time_element = document.getElementById('count_time');    

    let time = setInterval(() => {        
        console.log(sec);
        
        if(sec <= 0){
            document.getElementById('link_vote').click()
            clearInterval(sec);
            return;
        }

        sec--;
        time_element.innerHTML = sec;
    }, 1000)
});


