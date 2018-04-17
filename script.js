
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

const showMessage = (form, text) => {
    let p = document.createElement('p');
    p.setAttribute('class', 'v-vote_notice');
        let t = document.createTextNode(text);
    p.appendChild(t);
    form.appendChild(p);
}

const validate_form = (e) => {

    let f_vote = document.forms.form_vote;
    let input_vote = f_vote.user;
    if(input_vote.value == ''){
        input_vote.style.border = '1px solid red';
        showMessage(f_vote, 'Please write your user name');
        e.preventDefault();
        return;
    }

    let max_input_chars = f_vote.attributes.maxinputchars.value

    if(input_vote.value.length > max_input_chars){
        input_vote.value = '';
        showMessage(f_vote, 'max character: ' + max_input_chars);        
        e.preventDefault();
        return;
    }

    f_vote.submit();

}

document.getElementById('v-vote_submit').onclick = e => validate_form(e);