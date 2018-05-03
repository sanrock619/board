var code;

function createCode() {
    code = "";
	var codeLength = 4; // 驗證碼的長度
	var checkCode = document.getElementById("checkCode");
	var codeChars = new Array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9,); // 用來當作驗證碼的字串
	for (var i = 0; i < codeLength; i++) {
		var charNum = Math.floor(Math.random() * 10);
		code += codeChars[charNum];
	}
	if (checkCode) {
		checkCode.className = "code";
		checkCode.innerHTML = code;
	}
}

function validateCode() {
	var inputCode = document.getElementById("inputCode").value;
	if (inputCode.length <= 0) {
		alert("請輸入驗證碼！");
	}
	else if (inputCode.toUpperCase() != code.toUpperCase()) {
		alert("驗證碼錯誤！");
		createCode();
	}
	else {
		alert("驗證碼正確！");
		document.getElementById("submit").style.visibility="visible";
	}
}