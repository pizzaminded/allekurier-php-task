compose-up-arm:
	docker compose -f docker-compose.yaml -f docker-compose.override-arm.yaml up -d