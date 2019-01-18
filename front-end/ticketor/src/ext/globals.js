export default {
  apiDomain: "192.168.1.113:80",
  api(path, data=null) {
    return new Promise((resolve, reject) => {
      let settings = {
        url: this.apiDomain + path,
        type: 'POST',
        dataType: "json",
        success: (response, textStatus)=> {
          if (!response || !response.success) {
            reject(response ? response.error : textStatus);
          } else {
            resolve(response);
          }
        },
        error : (jqXHR, textStatus, errorThrown) => {
          reject(textStatus, errorThrown);
        }
      }
      data ? settings.data = data : null;

      $.ajax(settings);
    });
  }
}