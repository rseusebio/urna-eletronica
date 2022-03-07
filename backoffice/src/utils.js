export function getURL () {
    let url = "http://3.83.161.213:8080";

    if (window.location.href.includes("localhost")) {
        url = "http://localhost:8080";
    }

    return url;
}