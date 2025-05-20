 const cookieConsent = document.getElementById('cookieConsent');
    const acceptBtn = document.getElementById('acceptCookies');

     if (localStorage.getItem('cookiesAccepted') == 'true')
    {
      cookieConsent.style.setProperty('display', 'none', 'important');
    }

    if (!localStorage.getItem('cookiesAccepted')) {
      cookieConsent.style.display = 'flex';
    }

    acceptBtn.addEventListener('click', function () {
      localStorage.setItem('cookiesAccepted', 'true');
      cookieConsent.style.setProperty('display', 'none', 'important');
    });
