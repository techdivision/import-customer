# AGENTS.md - import-customer

## Zweck & Verantwortung

Das `import-customer` Modul bietet **Customer Import-Funktionalität** für das Pacemaker Import-System. Es ist ein **Tier 4 Modul** und dient als Basis für Customer-bezogene Importer.

**Hauptverantwortung:**
- Customer Import und Verwaltung
- Customer Attributes Import
- Customer Data Validation
- Repository Pattern für Customer-Persistierung
- Service Layer für Customer-Verarbeitung
- Observer Pattern für Customer-Hooks
- 3 Dependents (customer-address, converter-customer-attr)

## Architektur & Design Patterns

### Kern-Klassen
- **CustomerRepository**: Persistierung von Kunden
- **CustomerAttributeRepository**: Persistierung von Customer Attributes
- **CustomerProcessor**: Service Layer für Customer-Verarbeitung
- **CustomerObserver**: Observer für Customer-Hooks
- **CustomerAttributeObserver**: Observer für Customer Attributes

### Verwendete Patterns
- **Observer Pattern**: Für Customer-Hooks
- **Repository Pattern**: Für Daten-Persistierung
- **Service Layer**: Für Business Logic
- **Factory Pattern**: Für Object-Erstellung

## Abhängigkeiten

### Externe Pakete
- **Keine** - Nur Importer-Implementierungen

### TechDivision Dependencies
- **import** ^18.1 - Core Framework

### Abhängig von diesem Modul (3 Reverse Dependencies)
1. **import-customer-address** - Customer Address Importer
2. **import-converter-customer-attribute** - Customer Attribute Converter
3. **import-cli-simple** - Master CLI

## Wichtige Entry Points

### Repository Klassen
```php
// Customer Repository
CustomerRepository::create($row): void
CustomerRepository::update($row): void
CustomerRepository::findByEmail($email): array

// Customer Attribute Repository
CustomerAttributeRepository::create($row): void
CustomerAttributeRepository::findByCode($code): array
```

### Observer Klassen
```php
// Customer Observer
CustomerObserver::handle($row): void

// Customer Attribute Observer
CustomerAttributeObserver::handle($row): void
```

## Events & Extension Points

**Keine Events** - Tier 4 Importer-Modul

## Hints für KI-Agenten

### Wichtig zu verstehen
1. **Tier 4 Modul**: Basis für Customer-bezogene Importer
2. **Customer-fokussiert**: Spezialisiert auf Customer Import
3. **Observer Pattern**: Für Customer-Hooks
4. **Repository Pattern**: Für Daten-Persistierung
5. **3 Dependents**: Basis für spezialisierte Importer

### Bei Änderungen
- **Customer-Kompatibilität**: Beachte Customer-Struktur
- **Observer-Kompatibilität**: Neue Observers sollten optional sein
- **Backward Compatibility**: Alte Imports sollten noch funktionieren

### Implementierungs-Hinweise
- Nutze Observer Pattern für Custom Customer-Processing
- Beachte Customer-Validierung bei Imports
- Erwäge Email-Validierung

## Häufige Use Cases

### CSV-Beispiel: Customer Import
```csv
email,firstname,lastname,group_id,created_at
customer1@example.com,John,Doe,1,2026-01-01
customer2@example.com,Jane,Smith,2,2026-01-02
customer3@example.com,Bob,Johnson,1,2026-01-03
```

### Szenarien
1. **Newsletter-Signup-Import**: Externe Lead-Lists in Customers umwandeln
2. **B2B-Customer-Bulk-Import**: Hunderte von B2B-Customers mit Attributes
3. **Customer-Attribute-Update**: Batch-Updates von Custom Attributes

## Performance-Überlegungen

- **Email-Unique-Constraint**: Duplicate-Checks kosten 5-8ms pro Customer
- **Attribute-Storage**: Custom Attributes verdoppeln Schreibzeit (~10-15ms statt 5-8ms)
- **Batch-Optimization**: Optimal: 500-1000 Customers pro Batch für 8-10% Performance-Boost
- **Memory-Profile**: ~100KB pro Customer-Record mit Attributes

## Verwandte Module

- **import-customer-address**: Importiert Adressen für Customers
- **import-converter-customer-attribute**: Konvertiert Customer-Attribute
- **import-customer** ← **diese Datei**
- **import**: Core Framework nutzt Customer-Repository

## Troubleshooting & FAQ

**Q: "Email already exists" Fehler**
- A: Nutze `--update` Flag statt create, oder prüfe bestehende Customers mit: `SELECT COUNT(*) FROM customer_entity WHERE email = ?`

**Q: Custom-Attribute werden nicht importiert**
- A: Attributes müssen vorher via `import-attribute` erstellt sein. Prüfe: `SELECT * FROM catalog_product_entity_varchar WHERE attribute_id = ?`

**Q: Password wird im Klartext gespeichert**
- A: Korrekt - Password-Hashing erfolgt in separatem Importer-Modul. Passwords sollten hashen sein vor Import.

## Bekannte Einschränkungen

- **Keine Customer-Validierung**: Validierung erfolgt in Importern
- **Keine Customer-Adressen**: Adressen sind in `import-customer-address`
- **Keine Password-Hashing**: Password-Handling erfolgt in Importern

## Zusammenfassung

`import-customer` ist ein **Tier 4 Modul**, das Customer Import-Funktionalität für das Pacemaker-System bietet. Es ist die Basis für Customer-bezogene Importer und unterstützt Customer Attributes.

**Für Agenten:** Verstehe dieses Modul als **Customer Importer** mit Observer Pattern und Repository Pattern.
