// الانتظار حتى يتم تحميل كافة عناصر الصفحة
document.addEventListener('DOMContentLoaded', () => {
    
    // --- 1. برمجة القائمة الجانبية للموبايل (Mobile Menu) ---
    const menuBtn = document.querySelector('.mobile-menu-btn');
    const navLinks = document.querySelector('.nav-links');

    if(menuBtn) {
        menuBtn.addEventListener('click', () => {
            navLinks.classList.toggle('active'); // تبديل ظهور القائمة
        });
    }

    // --- 2. برمجة العداد التصاعدي للأرقام (Counter Animation) ---
    const stats = document.querySelectorAll('.stat-card h3');
    const speed = 200; // سرعة العداد

    const startCounter = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = entry.target;
                const updateCount = () => {
                    const dest = +target.getAttribute('data-target');
                    const count = +target.innerText.replace('+', '').replace(',', '');
                    const inc = dest / speed;

                    if (count < dest) {
                        target.innerText = "+" + Math.ceil(count + inc).toLocaleString();
                        setTimeout(updateCount, 1);
                    } else {
                        target.innerText = "+" + dest.toLocaleString();
                    }
                };
                updateCount();
                observer.unobserve(target); // تشغيله مرة واحدة فقط
            }
        });
    };

    const counterObserver = new IntersectionObserver(startCounter, { threshold: 0.5 });
    stats.forEach(stat => counterObserver.observe(stat));

    // --- 3. برمجة الوضع الليلي (Dark Mode) ---
    const themeBtn = document.querySelector('.theme-toggle');
    const currentTheme = localStorage.getItem('theme');

    // التأكد من الثيم المحفوظ سابقاً
    if (currentTheme === 'dark') {
        document.body.classList.add('dark-theme');
    }

    if(themeBtn) {
        themeBtn.addEventListener('click', () => {
            document.body.classList.toggle('dark-theme');
            let theme = 'light';
            if (document.body.classList.contains('dark-theme')) {
                theme = 'dark';
            }
            localStorage.setItem('theme', theme); // حفظ خيار المستخدم
        });
    }
});


// --- برمجة تصفية مراكز التبرع حسب المدينة ---
const citySelect = document.getElementById('city-select');
const locationCards = document.querySelectorAll('.location-card');

if (citySelect) {
    citySelect.addEventListener('change', function() {
        const selectedCity = this.value;

        locationCards.forEach(card => {
            // الحصول على مدينة الكرت من خاصية data-city
            const cardCity = card.getAttribute('data-city');

            if (selectedCity === 'all' || selectedCity === cardCity) {
                card.style.display = 'flex'; // إظهار الكرت
                card.classList.add('fade-in'); // إضافة أنيميشن الظهور
            } else {
                card.style.display = 'none'; // إخفاء الكرت
            }
        });
    });
}
// --- تفعيل الأسئلة الشائعة (Accordion) ---
const acc = document.getElementsByClassName("accordion-LC");

for (let i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        // تبديل الكلاس النشط لتغيير الأيقونة واللون
        this.classList.toggle("active");

        // إظهار/إخفاء المحتوى بسلاسة
        const panel = this.nextElementSibling;
        if (panel.style.maxHeight) {
            panel.style.maxHeight = null;
        } else {
            panel.style.maxHeight = panel.scrollHeight + "px";
        }
    });
}

// --- معالجة نموذج التواصل ---
const contactForm = document.getElementById('contact-form-LC');

if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // هنا يمكنك إضافة منطق الإرسال الحقيقي (AJAX)
        alert('شكراً لتواصلك معنا! تم استلام رسالتك وسنقوم بالرد عليك في أقرب وقت.');
        
        contactForm.reset(); // إعادة تعيين الحقول
    });
}




document.addEventListener('DOMContentLoaded', () => {
    
    // 1. تحديد العناصر من الصفحة
    const verifyBtn = document.getElementById('verifyBtn');
    const resultDiv = document.getElementById('checkResult');
    const donationForm = document.getElementById('donationForm');
    const checkboxes = document.querySelectorAll('.DN-check input[type="checkbox"]');
    
    // الحصول على جميع الحقول داخل الفورم (input, select, button)
    let formElements = [];
    if (donationForm) {
        formElements = donationForm.querySelectorAll('input, select, button');
    }

    // --- وظيفة مساعدة لتعطيل أو تفعيل الحقول ---
    const toggleFormFields = (isDisabled) => {
        formElements.forEach(element => {
            element.disabled = isDisabled;
        });
        // إضافة تأثير بصري للفورم (شفافية خفيفة عند التعطيل)
        if (donationForm) {
            donationForm.style.opacity = isDisabled ? "0.6" : "1";
            donationForm.style.pointerEvents = isDisabled ? "none" : "auto";
        }
    };

    // تعطيل الفورم فور تحميل الصفحة
    if (donationForm) {
        toggleFormFields(true);
    }

    let isEligible = false; 

    // 2.  زر "تحقق الآن"
    if (verifyBtn) {
        verifyBtn.addEventListener('click', () => {
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);

            if (allChecked) {
                isEligible = true;
                toggleFormFields(false); // فك القفل علي الفورم
                resultDiv.innerHTML = "✅ أنت مؤهل للتبرع، يمكنك الآن تعبئة البيانات.";
                resultDiv.style.color = "#2e7d32";
                resultDiv.classList.add('success');
                resultDiv.classList.remove('error');
            } else {
                isEligible = false;
                toggleFormFields(true); // إعادة قفل الفورم إذا أزال علامة من المربعات
                resultDiv.innerHTML = "❌ عذراً، يجب أن تستوفي جميع الشروط أولاً.";
                resultDiv.style.color = "#c62828";
                resultDiv.classList.add('error');
                resultDiv.classList.remove('success');
            }
        });
    }

    // 3. برمجة منع إرسال الفورم (كطبقة حماية إضافية)
    if (donationForm) {
        donationForm.addEventListener('submit', (e) => {
            if (!isEligible) {
                e.preventDefault(); 
                alert("تنبيه: لا يمكنك الإرسال لأنك غير مؤهل.");
                document.querySelector('.DN-check').scrollIntoView({ behavior: 'smooth' });
            } else {
                alert("تم إرسال طلب التبرع بنجاح! شكراً لك.");
            }
        });
    }
});





const urgencyRadios = document.querySelectorAll('input[name="urgency"]');
const cardRQ = document.querySelector('.card-RQ');

if (urgencyRadios && cardRQ) {
    urgencyRadios.forEach(radio => {
        radio.addEventListener('change', (e) => {
            if (e.target.value === 'urgent') {
                // إضافة برواز أحمر ينبض عند اختيار حالة طارئة
                cardRQ.style.border = "2px solid #cc1b1b";
                cardRQ.style.boxShadow = "0 0 20px rgba(204, 27, 27, 0.4)";
            } else {
                // العودة للشكل الطبيعي
                cardRQ.style.border = "none";
                cardRQ.style.boxShadow = "var(--shadow-md)";
            }
        });
    });
}

const phoneInput = document.querySelector('input[type="tel"]');

if (phoneInput) {
    phoneInput.addEventListener('input', function() {
        const pattern = /^09[0-9]{8}$/;
        if (!pattern.test(this.value)) {
            this.style.borderColor = "#cc1b1b"; // أحمر إذا كان الخطأ
        } else {
            this.style.borderColor = "#2e7d32"; // أخضر إذا كان صحيحاً
        }
    });
}


const unitsInput = document.querySelector('input[type="number"]');

if (unitsInput) {
    unitsInput.addEventListener('change', function() {
        if (this.value > 10) {
            alert("للطلبات التي تزيد عن 10 أكياس، يرجى التواصل مع إدارة المستشفى مباشرة.");
            this.value = 10;
        }
    });
}


