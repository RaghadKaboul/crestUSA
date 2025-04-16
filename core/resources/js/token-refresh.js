// إعداد التحديث التلقائي للتوكن
function refreshToken() {
    fetch('/api/refresh-token', {
        method: 'POST',
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('accessToken')}`, // التوكن الحالي
            'Content-Type': 'application/json'
        }
    }).then(response => response.json())
        .then(data => {
            if (data.token) {
                // تحديث التوكن في التخزين المحلي
                localStorage.setItem('accessToken', data.token);
                console.log('Token refreshed successfully!');
            }
        }).catch(error => {
        console.error('Error refreshing token:', error);
    });
}

// استدعاء التحديث التلقائي كل 15 دقيقة
setInterval(refreshToken, 15 * 60 * 1000); // كل 15 دقيقة
