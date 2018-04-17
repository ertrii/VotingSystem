
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

class Validate{
    constructor(form){
        this.ev = null;             //event
        this.f = form;
        this.element_p = false;
    }

    showMessage(text){            
        this.ev.preventDefault();
        if(this.element_p === false){
            this.element_p = document.createElement('p');
            this.element_p.setAttribute('class', 'v-vote_notice');
                let t = document.createTextNode(text);
            this.element_p.appendChild(t);
            this.f.appendChild(this.element_p);            
            
        }else{
            this.element_p.innerHTML = text;            
        }        
    }

    form(e){
        this.ev = e;

        let input_vote = this.f.user;
        if(input_vote.value == ''){
            input_vote.style.border = '1px solid red';
            this.showMessage('Please write your user name');            
            return;
        }

        let max_input_chars = this.f.attributes.maxinputchars.value

        if(input_vote.value.length > max_input_chars){
            input_vote.value = '';
            this.showMessage('max character: ' + max_input_chars);
            return;
        }
        
    }
}

const validate = new Validate(document.forms.form_vote);
document.getElementById('v-vote_submit').onclick = e => validate.form(e);
