compose-up-arm:
	docker compose -f docker-compose.yaml -f docker-compose.override-arm.yaml up -d

shell:
	docker compose exec ak_invoice_php bash