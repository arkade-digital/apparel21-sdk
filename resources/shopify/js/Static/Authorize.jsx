import React, {Component} from 'react';
import {
    Layout,
    Page,
    FooterHelp,
    Card,
    Link,
    Button,
    FormLayout,
    TextField
} from '@shopify/polaris';

class Authorize extends Component {
    constructor(props) {
        super(props);
        this.state = {
            shop: ''
        };
    }

    render() {
        return (
          <Page
            title="Apparel21 Syncer"
            separator
          >
              <Layout>
                  <Layout.AnnotatedSection
                    title="We need some information"
                    description="To gain access to your Shopify account, we first need your permission."
                  >
                      <Card sectioned>
                          <form action="">
                              <FormLayout>
                                  <TextField
                                    autoFocus
                                    type="text"
                                    name="shop"
                                    label="Shop name"
                                    value={this.state.shop}
                                    onChange={this.valueUpdater('shop')}
                                    placeholder="acme-corp.myshopify.com"
                                  />
                                  <Button primary submit>Install app</Button>
                              </FormLayout>
                          </form>
                      </Card>
                  </Layout.AnnotatedSection>
              </Layout>
              <FooterHelp>
                  <Link url="mailto:support@arkade.com.au" external>Contact Arkade</Link> for support
              </FooterHelp>
          </Page>
        )
    }

    valueUpdater(field) {
        return (value) => this.setState({[field]: value});
    }
}

export default Authorize;