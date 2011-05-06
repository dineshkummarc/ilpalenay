//random number for dc
//var ord = Math.round(Math.random() * 10000000000);
var abc = Math.random() + "";
var ord = abc.substring(2,abc.length);

//Atomz Search Code

function searchverif() {
   if (document.searchForm.query.value.length < 1) {
       alert("Your search query is blank. Please enter a search term.");
       return false;
   }
   return true;
}

function processQuery() {

var d = document.searchForm;
var q = d.elements['query'].value;
q = q.replace(/&quot;/g, "%22");

// set collection
d.elements['c'].value = d.elements['sp-q-1'].value;
// set sp-q
d.elements['sp-q'].value = d.elements['query'].value;

var pat = /C\+\+/gi;
test = q.match(pat);
if (test != null) {
   d.elements['sp-q'].value = d.elements['sp-q'].value.replace(pat, "CPLUSPLUS");
   }

var pat = /C#/i;
test = q.match(pat);
if (test != null) {
   d.elements['sp-q'].value = d.elements['sp-q'].value.replace(pat, "CNUM");
   }

}
