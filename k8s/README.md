# Kubernetes Deployment

This folder contains a fresh Kubernetes setup for the Notes app.

## Architecture

- `mysql` runs in its own Pod.
- `notes-app` Deployment runs both containers in a single Pod:
  - `backend` on port `8000`
  - `frontend` on port `5173`
- Services:
  - `frontend` NodePort: `30517`
  - `backend` NodePort: `30800`
  - `mysql` ClusterIP: `3306`

## 1) Prerequisites

- A Kubernetes cluster
- `kubectl` configured
- Images pushed to GHCR:
  - `ghcr.io/<owner>/notes-backend:<tag>`
  - `ghcr.io/<owner>/notes-frontend:<tag>`

## 2) Create secret

Option A (recommended):

```bash
kubectl create namespace notes-app --dry-run=client -o yaml | kubectl apply -f -
kubectl -n notes-app create secret generic notes-secrets \
  --from-literal=APP_KEY='base64:YOUR_APP_KEY' \
  --from-literal=JWT_SECRET='YOUR_JWT_SECRET' \
  --from-literal=MYSQL_ROOT_PASSWORD='YOUR_DB_PASSWORD' \
  --dry-run=client -o yaml | kubectl apply -f -
```

Option B: copy `secret.example.yaml` to `secret.yaml`, update values, then apply.

## 3) Update runtime config

Edit `k8s/configmap.yaml`:

- `APP_URL`
- `FRONTEND_URL`
- `FRONTEND_URLS`

## 4) Apply manifests

```bash
kubectl apply -k k8s
```

## 5) Set image tags

```bash
kubectl -n notes-app set image deployment/notes-app \
  backend=ghcr.io/<owner>/notes-backend:<tag> \
  frontend=ghcr.io/<owner>/notes-frontend:<tag>
```

## 6) Verify

```bash
kubectl -n notes-app get pods,svc
kubectl -n notes-app logs deployment/notes-app -c backend --tail=100
kubectl -n notes-app logs deployment/notes-app -c frontend --tail=100
```

Open:

- Frontend: `http://<NODE_IP>:30517`
- API: `http://<NODE_IP>:30800/api`

## GitHub Actions automation

Workflow `.github/workflows/cicd.yml` now includes a `Deploy to Kubernetes` job.

Required repository secrets:

- `KUBE_CONFIG_DATA` (base64-encoded kubeconfig)
- `APP_KEY`
- `JWT_SECRET`
- `MYSQL_ROOT_PASSWORD`

Optional secrets:

- `K8S_APP_URL` (default: `http://13.60.156.18:30800`)
- `K8S_FRONTEND_URL` (default: `http://13.60.156.18:30517`)
- `K8S_API_BASE_URL` (used at frontend image build time)

### Remote cluster requirement

`KUBE_CONFIG_DATA` must point to a remote-reachable API server (not `127.0.0.1` or `localhost`).

Generate GitHub-safe kubeconfig from your remote context:

```bash
kubectl config use-context <REMOTE_CONTEXT_NAME>
kubectl config view --raw --flatten --minify > kubeconfig-github.yaml
base64 -w 0 kubeconfig-github.yaml
```

Use the base64 output as `KUBE_CONFIG_DATA`.

## Important note about frontend API URL

The frontend image bakes `VITE_API_BASE_URL` at build time. Build frontend with the API URL you plan to expose:

```bash
docker build -t ghcr.io/<owner>/notes-frontend:<tag> \
  --build-arg VITE_API_BASE_URL=http://<NODE_IP>:30800/api \
  ./notes-frontend
```
