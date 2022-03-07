function ajax(url, method, callback) {
  let request = new XMLHttpRequest();
  request.overrideMimeType("application/json");
  request.open(method, url, true);
  request.onreadystatechange = () => {
    if (request.readyState === 4 && request.status == "200") {
      callback(request.responseText, request);
    }
  };
  request.send(null);
}


function vote(vereadorId, prefeitoId) {
  console.log("location: ", window.location.href);

  let url = "http://3.83.161.213:8080";

  if (window.location.href.includes("localhost")) {
    url = "http://localhost:8080";
  }

  const callback = (res, req) => {
    console.log("response: ", res, "request: ", req);
  }

  ajax(url + `/vote/${vereadorId}/${prefeitoId}`, "POST", callback);
}