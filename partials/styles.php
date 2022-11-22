<style>

@import url(https://fonts.googleapis.com/css?family=Roboto:300);

*{
	padding: 0;
	margin: 0;
	box-sizing: border-box;
}

body {
	font-family: "Roboto", sans-serif;
	background-color: white;
	font-size: 1rem;
}

a {
	text-decoration: none;
}

.container {
    max-width: 90%;
    margin: 1rem auto;
    padding: 0 1rem;
    overflow: hidden;
}

.form-input{
	outline: 0;
	background: #f2f2f2;
	width: 100%;
	min-width: 150px;
	border: 0;
	margin: 0 0 15px;
	padding: 10px;
}

.input-group{
	display: flex;
}

.input-group .form-input{
	margin-right: 5px;
}

.header{
	text-align: center;
}

.Error {
	color: red;
	font-size: 20px;
	padding-left: 10px;
	padding-right: 10px;
	text-align: center;
}


/* utils: buttons */

.btn {
  	margin: 0 auto;
	display: block;
	background-color: #333;
	color: white;
	padding: 15px 20px;
  	border-radius: 7px;
	cursor: pointer;
}

.btn:hover{
  border: .5px solid #333;
  background-color: #ddd;
  color: #333;
}

.btn:disabled,
.btn[disabled]{
  border: 1px solid #999999;
  background-color: #cccccc;
  color: #666666;
}

.btn-small{
	padding: 5px 10px;
	font-size: .75rem;
}

.btn-block{
	width: 100%;
}


/* utils: question table */

table{
	width: 100%;
	border: 3px solid #fff;
	box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}

table tbody td{
	padding: .5rem;
}

table thead th {
  font-weight: 400;
  background: grey;
  color: #FFF;
}

table th, td {
  text-align: left;
  padding: 10px;
  font-weight: 300;
}


table tbody tr:nth-child(odd) {
  background-color: #eee;
}

table tbody tr:nth-child(even) {
  background-color: #e5e5e5;
}


#HeaderQuestions{
	float: left;
  	color: black;
  	text-align: center;
  	text-decoration: none;
  	font-size: 15px;
}

.topnav {
	background-color: #333;
	overflow: hidden;
}
  
.topnav a {
	float: left;
	color: #f2f2f2;
	text-align: center;
	padding: 14px 16px;
	text-decoration: none;
	font-size: 17px;
}
  
.topnav a:hover {
	background-color: #ddd;
	color: black;
}

/* section: login */
#LoginPage{
	margin-top: 2rem;
	
}

#LoginPage .login-form{
	padding: 1.5rem;
	border: 1px solid #333;
	border-radius: 5px;
	width: 300px;
	margin: auto;
	box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}


#LoginPage .login-form .btn{
	width: 100%;
}


/*section: add question */
#add_question_form {
	display: flex;
}

#add_question_form #question_form{
	padding: .5rem;
	border: 1px solid #333;
	flex: 1;
	border-radius: 5px;
	box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
	margin-right: 1rem;
}

#add_question_form #question_container{
	flex: 2;
}

/* section: create exam */

#create_exam{
	padding: 2rem;
	display: flex;
}

#create_exam #exam_form{
	flex: 2;
	padding: 1.5rem;
	border: 1px solid #333;
	border-radius: 5px;
	box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
	margin-right: 1rem;
}

#create_exam .question-table{
	flex: 1;
}



/*section: take exam */


#take_exam {
	display: flex;
}

#take_exam #question_select{
	flex: 1;

} 

#take_exam #question_select button{
	width: 150px;
	margin-bottom: 5px;
	
} 


#take_exam #question_window{
	
	flex: 2;
	
} 

#take_exam #question_window .exam-question{
	display: none;
	padding: 1.5rem;
	border: 1px solid #333;
	border-radius: 5px;
	box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
	margin-right: 1rem;
}

/*section: auto grading */

#exam_grading .exam-answers{
	display: flex;
	margin-bottom: 1rem;
	
}

#exam_grading .exam-answers .student-answer{
	flex: 1;
	margin-right: 1rem;
	padding: .5rem;
	border: 1px solid #333;
	border-radius: 5px;
	box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}

#exam_grading .exam-answers .grading-table{
	flex: 2;
}

</style>