
# Part 2 - Case Study

Author: [Nasrul Hazim](https://github.com/nasrulhazim)

**Scenario**

Our system has been experiencing intermittent slowdowns during peak hours, impacting user experience. You are tasked with investigating and resolving the issue.

**Information Provided**

System logs indicate increased database queries during peak hours.
The application server is utilizing a high percentage of CPU resources.

## What are your initial steps to diagnose the performance bottleneck?

The initial steps required is to review the logs given, Look for error messages, slow query logs and unusual activity in lgos.

We also can monitor with `htop` or `top` command to monitor CPU, memory, and I/O usage.

For better monitoring, we can use monitoring tool such as Elastic Stack or Graphana to track server metrics over time.

For database, use tools like MySQL Workbench (if you are using MySQL) to identify the slow queries. Run `EXPLAIN` or `EXPLAIN EXTENDED` to identify if there's any misconfigured / anomaly in using the queries.

We also need to review the application codes, see if there's any recent code changes deployed. If there is, that might be contributing to performance issues. Check for inefficient algorithms, unnecessary loops, and excessive database queries within the application code.

## Describe potential causes for the increased database queries and high CPU usage

There is possiblities with ineffiecient database queries which not optimised, lack of proper indexing and even have N+1 query problems.

It is also can be contributed by high traffic during peak hourse which require more database queries and higher CPU usage.

It is also common cases where the code did not cache the query resuls - this often happen when query lookup data, user's profile or even cart information.

It is also possible due to multiple processes competing for CPU resources, leading to contention and high CPU usage.

## Strategies to Optimize the Application's Performance for Handling Peak Loads

We can improve the application performance by:

1. Database Optimisation
    - Use indexing to speed up query performance(but do take note, it also increasing the usage of storage to store the index data)
    - Refactor queries to remove N+1 problem
    - Implement database replication and sharding to distribute the load
    - Use read replicas to handle read-heavy workloads
2. Implement Caching
    - Frequently accessed data
    - Query Results
    - API Resopnses
    - Other computational expensive operations
3. Load Balancing
    - Distribute incoming traffics with load balancer - such as NGINX, HAProxy
    - Allows horizontal scalability - containerization is a good option, it's allows easy scale up or down.
4. Asynchronous Processing
    - Offload background tasks and long-running processes to job queues
5. Code Optimization
    - Refactor inefficient code to reduce CPU and database load
    - Implement pagination for large datasets to minimize memory usage
6. Performance Testing
    - Conduct load testing using tools like Apache JMeter, Gatling, or Locust to identify performance bottlenecks.
    - Simulate peak traffic conditions and monitor the system's behavior.

## Ensuring System Availability and Reliability During Troubleshooting

### Use a Staging Environment

Test changes in a staging environment that mirrors the production setup to avoid impacting live users.

### Real-Time Monitoring

- Continuously monitor system performance and set up alerts for critical metrics (e.g., CPU usage, response time).
- Use monitoring tools like Elastic Stack, or Grafana for real-time insights.

### Redundancy and Failover

- Implement failover mechanisms to ensure high availability (e.g., database replication, multiple application servers).
- Use redundant servers to handle failover in case of hardware or software failures.

### Incremental Rollout

Deploy changes incrementally (e.g., canary releases, blue-green deployments) to monitor their impact before a full rollout.

### Backup and Recovery

Ensure regular backups of the database and critical data.
Have a recovery plan in place to restore services quickly in case of data loss or corruption.
