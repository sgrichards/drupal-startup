FROM java:jre

ENV SOLR_VERSION 4.10.4
ENV SOLR solr-$SOLR_VERSION
ENV JAVA_HOME /usr/lib/jvm/java-7-openjdk-amd64

ENV SOLR_USER solr
ENV SOLR_UID 8983

RUN groupadd -r $SOLR_USER && \
  useradd -r -u $SOLR_UID -g $SOLR_USER $SOLR_USER

RUN \
    curl -SL http://archive.apache.org/dist/lucene/solr/$SOLR_VERSION/$SOLR.tgz | tar -xzC /opt && \
    curl -SL https://ftp.drupal.org/files/projects/search_api_solr-8.x-1.0-alpha6.tar.gz | tar -xzC /tmp && \
    ln -s /opt/$SOLR/example /opt/solr && \
    cp -R /tmp/search_api_solr/solr-conf/4.x/* /opt/$SOLR/example/solr/collection1/conf && \
    chown -R $SOLR_USER:$SOLR_USER /opt/solr

ENV SOLR_HOME /opt/solr

EXPOSE 8983
WORKDIR /opt/solr
ENTRYPOINT [ "java", "-Xmx1024m", "-DSTOP.PORT=8079", "-DSTOP.KEY=stopkey", "-Dsolr.solr.home=solr", "-jar", "start.jar" ]
