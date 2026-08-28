require('dotenv').config();
const mysql = require('mysql2/promise');
const sdk = require('node-appwrite');

const APPWRITE_ENDPOINT = process.env.APPWRITE_ENDPOINT;
const APPWRITE_PROJECT_ID = process.env.APPWRITE_PROJECT_ID;
const APPWRITE_API_KEY = process.env.APPWRITE_API_KEY;

const DB_ID = 'buniverse_newsletter';

const client = new sdk.Client()
    .setEndpoint(APPWRITE_ENDPOINT)
    .setProject(APPWRITE_PROJECT_ID)
    .setKey(APPWRITE_API_KEY);

const databases = new sdk.Databases(client);

// Helper to wait until all attributes of a collection are "available"
async function waitForAttributes(databaseId, collectionId, expectedCount) {
    console.log(`Waiting for attributes in ${collectionId} to be ready...`);
    while (true) {
        try {
            const col = await databases.getCollection(databaseId, collectionId);
            const readyAttrs = col.attributes.filter(attr => attr.status === 'available');
            console.log(`- ${col.name}: ${readyAttrs.length}/${expectedCount} attributes ready.`);
            if (readyAttrs.length >= expectedCount) {
                break;
            }
        } catch (e) {
            console.error(`Error checking collection status: ${e.message}`);
        }
        await new Promise(resolve => setTimeout(resolve, 2000));
    }
}

async function run() {
    // 1. Connect to MySQL
    const connection = await mysql.createConnection({
        host: process.env.DB_HOST,
        user: process.env.DB_USER,
        password: process.env.DB_PASS,
        database: process.env.DB_NAME
    });
    console.log('Connected to MySQL database.');

    // 2. Create Appwrite Database
    try {
        await databases.create(DB_ID, 'BUniverse Newsletter');
        console.log('Created Appwrite Database: BUniverse Newsletter');
    } catch (e) {
        if (e.code === 409) {
            console.log('Appwrite Database already exists.');
        } else {
            throw e;
        }
    }

    // Define Schemas
    const schemas = [
        {
            id: 'newsletters',
            name: 'Newsletters',
            attributes: [
                { key: 'portal', type: 'enum', elements: ['beritasatu', 'investor', 'jakartaglobe'], required: true },
                { key: 'subject', type: 'string', size: 255, required: true },
                { key: 'volume', type: 'integer', required: false, default: 1 },
                { key: 'greeting_title', type: 'string', size: 255, required: false },
                { key: 'greeting_body', type: 'string', size: 5000, required: false },
                { key: 'status', type: 'enum', elements: ['draft', 'sent'], required: false, default: 'draft' },
                { key: 'created_at', type: 'string', size: 50, required: false },
                { key: 'sent_at', type: 'string', size: 50, required: false }
            ]
        },
        {
            id: 'newsletter_articles',
            name: 'Newsletter Articles',
            attributes: [
                { key: 'newsletter_id', type: 'string', size: 50, required: true },
                { key: 'article_type', type: 'enum', elements: ['main', 'sidebar', 'grid', 'list', 'alternating'], required: true },
                { key: 'title', type: 'string', size: 555, required: true },
                { key: 'excerpt', type: 'string', size: 5000, required: false },
                { key: 'image_url', type: 'string', size: 555, required: false },
                { key: 'category', type: 'string', size: 100, required: false },
                { key: 'url', type: 'string', size: 555, required: false },
                { key: 'sort_order', type: 'integer', required: false, default: 0 }
            ]
        },
        {
            id: 'market_stats',
            name: 'Market Stats',
            attributes: [
                { key: 'newsletter_id', type: 'string', size: 50, required: true },
                { key: 'label', type: 'string', size: 100, required: true },
                { key: 'value', type: 'string', size: 50, required: true },
                { key: 'direction', type: 'enum', elements: ['up', 'down'], required: true },
                { key: 'sort_order', type: 'integer', required: false, default: 0 }
            ]
        },
        {
            id: 'subscribers',
            name: 'Subscribers',
            attributes: [
                { key: 'name', type: 'string', size: 255, required: true },
                { key: 'email', type: 'string', size: 255, required: true },
                { key: 'status', type: 'enum', elements: ['active', 'inactive'], required: false, default: 'active' },
                { key: 'created_at', type: 'string', size: 50, required: false }
            ]
        },
        {
            id: 'newsletter_send_logs',
            name: 'Newsletter Send Logs',
            attributes: [
                { key: 'newsletter_id', type: 'string', size: 50, required: true },
                { key: 'portal', type: 'enum', elements: ['beritasatu', 'investor', 'jakartaglobe'], required: true },
                { key: 'subject', type: 'string', size: 255, required: true },
                { key: 'volume', type: 'integer', required: true },
                { key: 'sent_at', type: 'string', size: 50, required: false },
                { key: 'recipients_count', type: 'integer', required: true },
                { key: 'content_summary', type: 'string', size: 10000, required: false }
            ]
        },
        {
            id: 'newsletter_send_recipients',
            name: 'Newsletter Send Recipients',
            attributes: [
                { key: 'send_log_id', type: 'string', size: 50, required: true },
                { key: 'subscriber_name', type: 'string', size: 255, required: true },
                { key: 'subscriber_email', type: 'string', size: 255, required: true },
                { key: 'status', type: 'enum', elements: ['success', 'failed'], required: true },
                { key: 'error_message', type: 'string', size: 5000, required: false }
            ]
        }
    ];

    // 3. Create Collections & Attributes
    for (const schema of schemas) {
        try {
            await databases.createCollection(DB_ID, schema.id, schema.name);
            console.log(`Created Collection: ${schema.name}`);
        } catch (e) {
            if (e.code === 409) {
                console.log(`Collection ${schema.name} already exists.`);
            } else {
                throw e;
            }
        }

        // Create Attributes
        for (const attr of schema.attributes) {
            try {
                if (attr.type === 'string') {
                    await databases.createStringAttribute(DB_ID, schema.id, attr.key, attr.size, attr.required, attr.default);
                } else if (attr.type === 'integer') {
                    await databases.createIntegerAttribute(DB_ID, schema.id, attr.key, attr.required, null, null, attr.default);
                } else if (attr.type === 'enum') {
                    await databases.createEnumAttribute(DB_ID, schema.id, attr.key, attr.elements, attr.required, attr.default);
                }
                console.log(`  - Created attribute: ${attr.key}`);
            } catch (e) {
                if (e.code === 409) {
                    // Already exists
                } else {
                    console.error(`Error creating attribute ${attr.key}:`, e.message);
                }
            }
        }
        // Wait for attributes to become available
        await waitForAttributes(DB_ID, schema.id, schema.attributes.length);
    }

    // 4. Migrate Data
    const tablesMap = [
        { mysqlTable: 'newsletters', appwriteCol: 'newsletters' },
        { mysqlTable: 'newsletter_articles', appwriteCol: 'newsletter_articles' },
        { mysqlTable: 'market_stats', appwriteCol: 'market_stats' },
        { mysqlTable: 'subscribers', appwriteCol: 'subscribers' },
        { mysqlTable: 'newsletter_send_logs', appwriteCol: 'newsletter_send_logs' },
        { mysqlTable: 'newsletter_send_recipients', appwriteCol: 'newsletter_send_recipients' }
    ];

    for (const mapping of tablesMap) {
        console.log(`Migrating data for table: ${mapping.mysqlTable}...`);
        const [rows] = await connection.query(`SELECT * FROM ${mapping.mysqlTable}`);
        
        for (const row of rows) {
            // Prepare document payload
            const docId = String(row.id);
            const payload = { ...row };
            delete payload.id; // remove local autoincrement ID from payload

            // Handle date conversion to ISO string format if necessary
            for (const key of Object.keys(payload)) {
                if (payload[key] instanceof Date) {
                    payload[key] = payload[key].toISOString();
                } else if (payload[key] === null) {
                    delete payload[key]; // Appwrite doesn't like null for optional attributes
                } else if (typeof payload[key] === 'number' && (key.endsWith('_id') || (mapping.mysqlTable === 'newsletter_articles' && key === 'url'))) {
                    // Convert foreign key numeric IDs or numeric fields where they should be strings
                    payload[key] = String(payload[key]);
                }
            }

            try {
                await databases.createDocument(DB_ID, mapping.appwriteCol, docId, payload);
                console.log(`  - Migrated document ID ${docId} to collection ${mapping.appwriteCol}`);
            } catch (e) {
                if (e.code === 409) {
                    console.log(`  - Document ID ${docId} already exists in ${mapping.appwriteCol}, updating instead.`);
                    await databases.updateDocument(DB_ID, mapping.appwriteCol, docId, payload);
                } else {
                    console.error(`  - Failed to migrate document ID ${docId} to ${mapping.appwriteCol}:`, e.message);
                }
            }
        }
    }

    console.log('Migration Completed Successfully!');
    await connection.end();
}

run().catch(console.error);
