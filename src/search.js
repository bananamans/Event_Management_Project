let availablekeywords=[
    'Seminar',
    'Private event'
];

const resultsBox=document.querySelector(".result-box");
const inputBox=document.getElementById("input-box");

inputBox.onkeyup = function(){
    let result = [];
    let input = inputBox. value;
    if(input.length){
        result=availablekeywords.filter((keyword)=>{
            return keyword.toLowerCase().includes(input.toLowerCase());
        });
    }
    display(result);
    if(!result.length){
        resultsBox.innerHTML='';
    }
}

function display(result) {
    const content = result.map((list) => {
      if (list === "Seminar")
        return "<li data-url='seminarForm.php'>Seminar</li>";
      if (list === "Private event")
        return "<li data-url='privateEventForm.php'>Private event</li>";
    });
  
    resultsBox.innerHTML = "<ul>" + content.join("") + "</ul>";
  
    const resultList = resultsBox.querySelector("ul");
    resultList.addEventListener("click", (event) => {
      const target = event.target;
      const listItem = target.closest("li");
      if (listItem) {
        const url = listItem.getAttribute("data-url");
        window.location.href = url; // Redirect to the specified URL
      }
    });
  }
  