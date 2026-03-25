# Kubernetes Deployment (Phase 1)

This setup mirrors your Docker Compose stack on Kubernetes:
- MySQL
- Laravel backend
- Vue frontend

It is designed for a single-node cluster first (k3s, minikube, or kubeadm) using `NodePort` services.

## 1) Prerequisites

- A working Kubernetes cluster
- `kubectl` configured to that cluster
- Images pushed to GHCR:
  - backend: `ghcr.io/<owner>/notes-backend:<tag>`
  - frontend: `ghcr.io/<owner>/notes-frontend:<tag>`

## 2) Create secrets

Option A (recommended): create directly with kubectl

```bash
kubectl create namespace notes-app --dry-run=client -o yaml | kubectl apply -f -
kubectl -n notes-app create secret generic notes-secrets \
  --from-literal=APP_KEY='base64:YOUR_APP_KEY' \
  --from-literal=JWT_SECRET='YOUR_JWT_SECRET' \
  --from-literal=MYSQL_ROOT_PASSWORD='YOUR_DB_PASSWORD' \
  --dry-run=client -o yaml | kubectl apply -f -
```

Option B: copy `secret.example.yaml` to `secret.yaml`, fill values, then apply.

## 3) Update runtime config

Edit `k8s/configmap.yaml` and set:
- `APP_URL`
- `FRONTEND_URL`
- `FRONTEND_URLS`

For single-node testing with NodePort, use your node public IP:
- Backend: `http://<NODE_IP>:30800`
- Frontend: `http://<NODE_IP>:30517`

## 4) Apply manifests

```bash
kubectl apply -f k8s/namespace.yaml
kubectl apply -f k8s/configmap.yaml
kubectl apply -f k8s/mysql-pvc.yaml
kubectl apply -f k8s/mysql-deployment.yaml
kubectl apply -f k8s/mysql-service.yaml
kubectl apply -f k8s/backend-deployment.yaml
kubectl apply -f k8s/backend-service.yaml
kubectl apply -f k8s/frontend-deployment.yaml
kubectl apply -f k8s/frontend-service.yaml
```

Or with kustomize:

```bash
kubectl apply -k k8s
```

## 5) Set image tags

```bash
kubectl -n notes-app set image deployment/backend backend=ghcr.io/<owner>/notes-backend:<tag>
kubectl -n notes-app set image deployment/frontend frontend=ghcr.io/<owner>/notes-frontend:<tag>
```

## 6) Verify

```bash
kubectl -n notes-app get pods,svc
kubectl -n notes-app logs deployment/backend --tail=100
```

Open:
- Frontend: `http://<NODE_IP>:30517`
- API: `http://<NODE_IP>:30800/api`

## Important note about frontend API URL

Your frontend image bakes `VITE_API_BASE_URL` at build time. Build frontend with the same API URL you plan to expose from Kubernetes.

Example:

```bash
docker build -t ghcr.io/<owner>/notes-frontend:<tag> \
  --build-arg VITE_API_BASE_URL=http://<NODE_IP>:30800/api \
  ./notes-frontend
```
