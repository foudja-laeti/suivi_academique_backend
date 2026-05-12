import http from 'k6/http';
import { check, sleep } from 'k6';

export const options = {
  stages: [
    { duration: '30s', target: 10 },  // montée à 10 users
    { duration: '1m',  target: 10 },  // maintien
    { duration: '10s', target: 0  },  // descente
  ],
  thresholds: {
    http_req_duration: ['p(95)<500'],  // 95% des requêtes < 500ms
    http_req_failed:   ['rate<0.01'],  // moins de 1% d'erreurs
  },
};

export default function () {
  const res = http.get('http://localhost:8000');
  check(res, {
    'status is 200': (r) => r.status === 200,
    'response time < 500ms': (r) => r.timings.duration < 500,
  });
  sleep(1);
}
