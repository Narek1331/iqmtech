// let iqmtechScriptTag = document.querySelector('script[src$="client.js"]');
const iqmtechScriptTag = document.querySelector('script[src*="iqmtech.ru"]');
const iqmtechToken = iqmtechScriptTag ? iqmtechScriptTag.getAttribute('token') : null;

if (iqmtechToken) {
    // Function to get UTM parameters from the URL
    function getUTMParams() {
        const urlParams = new URLSearchParams(window.location.search);
        return {
            utm_term: urlParams.get('utm_term') || '',
            utm_source: urlParams.get('utm_source') || '',
            utm_campaign: urlParams.get('utm_campaign') || '',
            utm_medium: urlParams.get('utm_medium') || '',
            utm_content: urlParams.get('utm_content') || ''
        };
    }

    // List of possible keys for phone number retrieval
    const phoneKeys = [
        'phone_number', 'phone', 'tel', 'telefon', 'nomer', 'nomer_telefona', 'nomer-telefon', 'mobile',
        'cell', 'contact_number', 'contact_tel', 'tel_number', 'phone_no', 'phone_numer', 'mobile_number',
        'mob_number', 'telephone', 'telephone_number', 'handphone', 'cell_number', 'phone_contact',
        'mobile_tel', 'mobile_phone', 'phone_contact_number', 'personal_phone', 'user_phone', 'user_tel',
        'user_mobile', 'user_contact', 'user_contact_number', 'user_phone_number', 'customer_phone',
        'customer_tel', 'customer_contact', 'customer_mobile', 'customer_number', 'client_phone', 'client_tel',
        'client_mobile', 'client_contact', 'client_number', 'work_phone', 'work_tel', 'work_mobile',
        'office_phone', 'office_tel', 'office_mobile', 'business_phone', 'business_tel', 'business_mobile',
        'home_phone', 'home_tel', 'home_mobile', 'home_number', 'emergency_phone', 'emergency_tel',
        'emergency_mobile', 'emergency_number', 'fax_number', 'contact_phone', 'contact_cell', 'phone1', 'phone2',
        'telephone1', 'telephone2', 'mobile1', 'mobile2'
    ];

    // List of possible keys for gender
    const genderKeys = [
        'gender', 'gen', 'pol', 'sex', 'gender_identity', 'gender_type', 'gender_role',
        'gender_classification', 'gender_expression', 'gender_status', 'sex_type',
        'gender_value', 'gender_label', 'gender_marker', 'gender_code', 'sex_identifier'
    ];

    // List of possible keys for age
    const ageKeys = [
        'age', 'dob', 'denrojdenie', 'date_of_birth', 'birthdate', 'birth_day', 'birth_year', 'dateOfBirth', 'birthday', 'birth_date'
    ];

    // Function to get phone from cookie
    function getPhoneFromCookie() {
        return phoneKeys.map(key => getCookie(key)).find(value => value) || null;
    }

    // Function to get gender from cookie
    function getGenderFromCookie() {
        return genderKeys.map(key => getCookie(key)).find(value => value) || null;
    }

    // Function to get age from cookie
    function getAgeFromCookie() {
        return ageKeys.map(key => getCookie(key)).find(value => value) || null;
    }

    // Function to get phone from local storage
    function getPhoneFromLocalStorage() {
        return phoneKeys.map(key => localStorage.getItem(key)).find(value => value) || null;
    }

    // Function to get gender from local storage
    function getGenderFromLocalStorage() {
        return genderKeys.map(key => localStorage.getItem(key)).find(value => value) || null;
    }

    // Function to get age from local storage
    function getAgeFromLocalStorage() {
        return ageKeys.map(key => localStorage.getItem(key)).find(value => value) || null;
    }

    // Function to get phone number (from cookie or local storage)
    function getPhoneNumber() {
        return getPhoneFromCookie() || getPhoneFromLocalStorage();
    }

    // Function to get gender (from cookie or local storage)
    function getGender() {
        return getGenderFromCookie() || getGenderFromLocalStorage();
    }

    // Function to get age (from cookie or local storage)
    function getAge() {
        return getAgeFromCookie() || getAgeFromLocalStorage();
    }

    // Function to get cookie value by name
    function getCookie(name) {
        const nameEQ = name + "=";
        const ca = document.cookie.split(';');
        for (const c of ca) {
            const cookie = c.trim();
            if (cookie.indexOf(nameEQ) === 0) return cookie.substring(nameEQ.length, cookie.length);
        }
        return null;
    }

    // Function to get geolocation
    async function getGeolocation() {
        return new Promise((resolve, reject) => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(position => {
                    resolve({
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude
                    });
                }, () => {
                    reject(null);
                });
            } else {
                reject(null);
            }
        });
    }

    // Fetching geolocation (or setting default values if not available)
    async function getLocationData() {
        try {
            const coords = await getGeolocation();
            return coords;
        } catch (error) {
            return { latitude: null, longitude: null };
        }
    }

    // Prepare the data and create the URL with query parameters
    async function prepareAndSendData() {
        const phoneNumber = getPhoneNumber();
        const gender = getGender();
        const age = getAge();
        // const geolocationData = await getLocationData(); // Get geolocation data asynchronously

        // Prepare the query parameters
        const params = new URLSearchParams({
            page: window.location.href,
            ref: document.referrer,
            phone: phoneNumber || '',
            browser: navigator.userAgent,
            device: /Mobi|Android|iPhone|iPad/i.test(navigator.userAgent) ? 'mobile' : 'desktop',
            platform: navigator.platform,
            // latitude: geolocationData.latitude,
            // longitude: geolocationData.longitude,
            gender: gender || '',
            age: age || '',
            ...getUTMParams()
        });

        // Construct the URL with all query parameters
        const url = `https://iqmtech.ru/api/sync/data?${params.toString()}`;
        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                  'Authorization': `Bearer ${iqmtechToken}`,
                  'Content-Type': 'application/json'
                },
              });
            const result = await response.json();
        } catch (error) {
        }
    }

    // Call the function to prepare and send data to the server
    prepareAndSendData();
}

console.log(44444)
